<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Invoice;
use App\Models\ProductLoan;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Exibe a listagem de empréstimos no dashboard.
     */
    public function index()
    {
        $productLoans = ProductLoan::where('user_id', Auth::id())
            ->whereHas('documents')
            ->with(['productLoanItems.product', 'user', 'documents'])
            ->get();


        return view('dashboardapp', compact('productLoans'));
    }

    /**
     * Exibe o formulário para edição de um documento.
     *
     * @param string $id O ID do documento a ser editado.
     */
    public function edit(string $id)
    {
        $document = Document::findOrFail($id);

        if ($document->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado para editar este documento.');
        }

        return view('documents.edit', compact('document'));
    }

    /**
     * Atualiza um documento existente com um novo arquivo XML.
     *
     * @param \Illuminate\Http\Request $request A requisição HTTP.
     * @param string $id O ID do documento a ser atualizado.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        if ($document->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado para atualizar este documento.');
        }

        try {
            $request->validate(['invoice_file' => 'required|file|mimes:xml']);

            $newXmlFilePath = $request->file('invoice_file')->store('invoices_xml_updates', 'public');
            $xmlContent = file_get_contents(Storage::disk('public')->path($newXmlFilePath));
            $xml = simplexml_load_string($xmlContent);

            if ($xml === false) {
                Storage::disk('public')->delete($newXmlFilePath);
                throw new \Exception('O novo arquivo XML é inválido e não pôde ser processado.');
            }

            $productData = [
                'category' => (string) $xml->product->category,
                'brand' => (string) $xml->product->brand,
                'model' => (string) $xml->product->model,
                'serial_number' => (string) $xml->product->serial_number,
                'processor' => (string) $xml->product->hardware->processor,
                'memory' => (string) $xml->product->hardware->memory,
                'disk' => (string) $xml->product->hardware->disk,
                'price' => (float) $xml->product->price->value,
                'price_string' => (string) $xml->product->price->string,
            ];

            DB::transaction(function () use ($document, $productData, $newXmlFilePath) {
                $mainProduct = $document->productLoan->productLoanItems->first()->product;
                $mainProduct->update($productData);

                Storage::disk('public')->delete($document->file_path_docx);
                Storage::disk('public')->delete($document->file_path_pdf);

                $user = $document->user;
                $templatePath = storage_path('app/templates/Anexo1.docx');
                $fileName = "termo_emprestimo_{$document->product_loan_id}_" . now()->format('YmdHis');
                $docxPath = "documents/{$fileName}.docx";
                $pdfPath = "documents/{$fileName}.pdf";

                $templateProcessor = new TemplateProcessor($templatePath);
                $templateProcessor->setValue('user_name', $user->name);
                $templateProcessor->setValue('user_role', $user->role);
                $templateProcessor->setValue('user_document', $user->cpf);
                $templateProcessor->setValue('product_brand', $mainProduct->brand);
                $templateProcessor->setValue('product_model', $mainProduct->model);
                $templateProcessor->setValue('product_serial_number', $mainProduct->serial_number);
                $templateProcessor->setValue('product_processor', $mainProduct->processor);
                $templateProcessor->setValue('product_memory', $mainProduct->memory);
                $templateProcessor->setValue('product_disk', $mainProduct->disk);
                $templateProcessor->setValue('product_price', number_format($mainProduct->price, 2, ',', '.'));
                $templateProcessor->setValue('product_price_string', $mainProduct->price_string);
                $templateProcessor->setValue('accessories_list', "Nenhum acessório adicional entregue.");
                $templateProcessor->setValue('local', 'Sua Cidade/UF');
                $templateProcessor->setValue('date', now()->format('d/m/Y'));

                $tempDocxPath = storage_path("app/public/{$docxPath}");
                $templateProcessor->saveAs($tempDocxPath);

                $htmlContent = view('documents.anexo1_html', compact('user', 'mainProduct'))->render();
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlContent);
                $dompdf->render();
                Storage::disk('public')->put($pdfPath, $dompdf->output());

                $document->update([
                    'file_path_docx' => $docxPath,
                    'file_path_pdf' => $pdfPath,
                ]);

                Storage::disk('public')->delete($newXmlFilePath);
            });

            return redirect()->route('dashboard')->with('success', 'Documento atualizado com sucesso!');
        } catch (\Exception $e) {
            if (isset($newXmlFilePath) && Storage::disk('public')->exists($newXmlFilePath)) {
                Storage::disk('public')->delete($newXmlFilePath);
            }
            Log::error("Erro ao atualizar documento: " . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao atualizar o documento: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove um documento do armazenamento e apaga o produto e empréstimo associados.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado para excluir este documento.');
        }

        try {
            DB::transaction(function () use ($document) {
                // Acessa o produto através da relação
                $product = $document->productLoan->productLoanItems->first()->product;
                $invoice = $product->invoice()->first();
                if ($invoice) {
                    $invoice->delete();
                }

                // Apaga os arquivos DOCX e PDF
                Storage::disk('public')->delete($document->file_path_docx);
                Storage::disk('public')->delete($document->file_path_pdf);

                // Apaga o produto
                $product->delete();

                // Apaga o empréstimo, que apaga o documento e os itens em cascata
                $document->productLoan->delete();
            });

            return redirect()->route('dashboard')->with('success', 'Documento excluído com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir documento: " . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao excluir o documento: ' . $e->getMessage());
        }
    }

    /**
     * Realiza o download de um documento.
     */
    public function download(string $id, string $type)
    {
        $document = Document::findOrFail($id);

        if ($document->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado para baixar este documento.');
        }

        $filePath = null;
        $mimeType = '';
        $fileName = "termo_emprestimo_{$document->product_loan_id}_" . now()->format('YmdHis');

        if ($type === 'pdf') {
            $filePath = $document->file_path_pdf;
            $mimeType = 'application/pdf';
            $fileName .= '.pdf';
        } elseif ($type === 'docx') {
            $filePath = $document->file_path_docx;
            $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            $fileName .= '.docx';
        } else {
            abort(404, 'Tipo de arquivo não suportado.');
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return response()->download(Storage::disk('public')->path($filePath), $fileName, [
            'Content-Type' => $mimeType,
        ]);
    }
}

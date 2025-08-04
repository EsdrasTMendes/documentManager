<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Exibe a view para criar um novo produto.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Armazena um novo produto e cria o empréstimo associado.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(['invoice_file' => 'required|file|mimes:xml']);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $filePath = $request->file('invoice_file')->store('invoices_xml', 'public');

            DB::transaction(function () use ($request, $filePath) {
                // Leitura e Parsing do XML
                $xmlContent = file_get_contents(Storage::disk('public')->path($filePath));
                $xml = simplexml_load_string($xmlContent);
                if ($xml === false) {
                    throw new \Exception('O arquivo XML é inválido e não pôde ser processado.');
                }

                $invoiceNumber = (string) $xml->number;
                if (empty($invoiceNumber)) {
                    throw new \Exception('O número da nota fiscal não foi encontrado ou está vazio no arquivo XML.');
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

                $mainProduct = Product::create([
                    'category' => $productData['category'],
                    'brand' => $productData['brand'],
                    'model' => $productData['model'],
                    'serial_number' => $productData['serial_number'],
                    'processor' => $productData['processor'],
                    'memory' => $productData['memory'],
                    'disk' => $productData['disk'],
                    'price' => $productData['price'],
                    'price_string' => $productData['price_string'],
                    'fl_avaliable' => false,
                ]);

                Invoice::create([
                    'product_id' => $mainProduct->id,
                    'invoice_number' => $invoiceNumber,
                    'user_id' => Auth::id(),
                    'file_path' => $filePath,
                ]);

                $loan = ProductLoan::create([
                    'user_id' => Auth::id(),
                    'loan_date' => now(),
                    'expected_return_date' => now()->addYears(1),
                    'status' => 'aprovado',
                ]);

                $loan->productLoanItems()->create(['product_id' => $mainProduct->id]);

                // Lógica de Geração de Documentos
                $user = Auth::user();
                $templatePath = storage_path('app/templates/Anexo1.docx');
                $fileName = "termo_emprestimo_{$loan->id}_" . now()->format('YmdHis');
                $docxPath = "documents/{$fileName}.docx";
                $pdfPath = "documents/{$fileName}.pdf";

                // 1. Gerar o DOCX
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

                // 2. Gerar o PDF (usando uma string HTML)
                // AQUI ESTÁ A CORREÇÃO CRUCIAL
                $htmlContent = view('documents.anexo1_html', compact('user', 'mainProduct'))->render();

                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlContent);
                $dompdf->render();
                Storage::disk('public')->put($pdfPath, $dompdf->output());

                Document::create([
                    'user_id' => Auth::id(),
                    'product_loan_id' => $loan->id,
                    'file_path_docx' => $docxPath,
                    'file_path_pdf' => $pdfPath,
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'Produto cadastrado via XML e empréstimo criado com sucesso!');
        } catch (\Exception $e) {
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            Log::error("Erro no fluxo de cadastro de produto via XML: " . $e->getMessage());
            return back()->with('error', 'Erro ao processar o arquivo XML: ' . $e->getMessage())->withInput();
        }
    }
}

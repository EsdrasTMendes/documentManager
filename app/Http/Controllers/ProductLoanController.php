<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use App\Models\ProductLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class ProductLoanController extends Controller
{
    public function index()
    {
        $productLoans = ProductLoan::where('user_id', Auth::id())->get();
        return view('product_loans.index', compact('productLoans'));
    }

    public function create()
    {
        $products = Product::where('fl_available', true)->get();
        return view('product_loans.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|string',
            'product_id' => 'required|array',
            'product_id.*' => 'required|integer|exists:products,id',
        ]);

        DB::transaction(function () use ($validated) {
            $loan = ProductLoan::create([
                'user_id' => Auth::id(),
                'loan_date' => $validated['loan_date'],
                'expected_return_date' => $validated['expected_return_date'],
                'status' => $validated['status'],
            ]);

            $mainProductId = $validated['product_id'][0];
            $mainProduct = Product::find($mainProductId);

            $loan->productLoanItems()->create(['product_id' => $mainProductId]);
            $mainProduct->update(['fl_avaliable' => false]);

            $user = Auth::user();

            $templatePath = storage_path('app/templates/Anexo1.docx');
            $fileName = "termo_emprestimo_{$loan->id}_" . now()->format('YmdHis');
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

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml(file_get_contents($tempDocxPath));
            $dompdf->render();
            Storage::disk('public')->put($pdfPath, $dompdf->output());

            Document::create([
                'user_id' => Auth::id(),
                'product_loan_id' => $loan->id,
                'file_path_docx' => $docxPath,
                'file_path_pdf' => $pdfPath,
            ]);

            return redirect()->route('product_loans.show', $loan)->with('success', 'Empréstimo registrado e documentos gerados com sucesso!');
        });

        return back()->with('error', 'Ocorreu um erro ao registrar o empréstimo.');
    }

    public function show(ProductLoan $productLoan)
    {
        $this->authorizeView($productLoan);

        $productLoan->load(['productLoanItems.product', 'documents']);

        return view('product_loans.show', compact('productLoan'));
    }

    public function destroy(ProductLoan $productLoan)
    {
        $this->authorizeView($productLoan);
        $productLoan->delete();
        return redirect()->route('product_loans.index')->with('success', 'Empréstimo deletado com sucesso!');
    }

    private function authorizeView(ProductLoan $loan)
    {
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProductLoan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'product_id' => 'required|array', // Valida se é um array de IDs
            'product_id.*' => 'required|integer|exists:products,id', // Valida cada ID no array
        ]);

        $loan = ProductLoan::create([
            'user_id' => Auth::id(),
            'loan_date' => $validated['loan_date'],
            'expected_return_date' => $validated['expected_return_date'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['product_id'] as $productId) {
            $loan->productLoanItems()->create([
                'product_id' => $productId,
            ]);
        }

        return redirect()->route('product_loans.show', $loan)->with('success', 'Empréstimo registrado com sucesso!');
    }

    public function show(ProductLoan $productLoan)
    {
        $this->authorizeView($productLoan);
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

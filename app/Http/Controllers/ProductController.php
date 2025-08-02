<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'serial_number' => 'required|string|max:255|unique:products,serial_number',
        'processor' => 'nullable|string|max:255',
        'memory' => 'nullable|integer|min:0',
        'disk' => 'nullable|integer|min:0',
        'price' => 'required|numeric|min:0',
        'price_string' => 'required|string|max:255',
        'category_id' => 'required|exists:product_categories,id',
        'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
        'invoice_file' => 'required|file|mimes:pdf,docx|max:2048',
    ]);

    $filePath = $request->file('invoice_file')->store('invoices', 'public');
    $product = Product::create($validated);

    Invoice::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'invoice_number' => $validated['invoice_number'],
        'file_path' => $filePath,
    ]);

    return redirect()->route('dashboard')->with('success', 'Produto e Nota Fiscal cadastrados com sucesso!');
    }
}

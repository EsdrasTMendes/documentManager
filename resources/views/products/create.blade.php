@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-4">Cadastrar Novo Produto e anexar Nota Fiscal</h2>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Campos do Produto --}}
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                    <input type="text" name="brand" id="brand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
                    <input type="text" name="model" id="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label for="serial_number" class="block text-sm font-medium text-gray-700">Número de Série</label>
                    <input type="text" name="serial_number" id="serial_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label for="processor" class="block text-sm font-medium text-gray-700">Processador</label>
                    <input type="text" name="processor" id="processor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="memory" class="block text-sm font-medium text-gray-700">Memória (Gb)</label>
                    <input type="number" name="memory" id="memory" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="disk" class="block text-sm font-medium text-gray-700">Disco Rígido (Gb)</label>
                    <input type="number" name="disk" id="disk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                    <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
                <div>
                    <label for="price_string" class="block text-sm font-medium text-gray-700">Preço por Extenso</label>
                    <input type="text" name="price_string" id="price_string" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                        <option value="">Selecione a categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Campo para o número da Nota Fiscal --}}
                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700">Número da Nota Fiscal</label>
                    <input type="text" name="invoice_number" id="invoice_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>

                {{-- Campo para upload da Nota Fiscal --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="invoice_file" class="block text-sm font-medium text-gray-700">Anexar Nota Fiscal (PDF ou DOCX)</label>
                    <input type="file" name="invoice_file" id="invoice_file" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Salvar Produto
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-4">Novo Empréstimo</h2>

        <form method="POST" action="{{ route('product_loans.store') }}">
            @csrf

            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Dados do Empréstimo</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="loan_date" class="block text-sm font-medium text-gray-700">Data do Empréstimo</label>
                        <input type="date" name="loan_date" id="loan_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                    </div>
                    <div>
                        <label for="expected_return_date" class="block text-sm font-medium text-gray-700">Data Prevista de Devolução</label>
                        <input type="date" name="expected_return_date" id="expected_return_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                            <option value="pending">Pendente</option>
                            <option value="approved">Aprovado</option>
                            <option value="returned">Devolvido</option>
                        </select>
                    </div>
                </div>

                <hr class="my-6">

                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Itens do Empréstimo</h3>

                @if($products->isEmpty())
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                        <p class="font-bold">Atenção:</p>
                        <p>Não existem produtos disponíveis para empréstimo.</p>
                    </div>
                @else
                    <div id="product-items-container">
                        <div class="item-group mb-4 p-4 border border-gray-200 rounded-md">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selecione o Produto</label>
                                    <select name="product_id[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                        <option value="">Selecione...</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->brand }} - {{ $product->model }} - {{ $product->serial_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-item" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Adicionar outro item
                    </button>
                @endif

            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" {{ $products->isEmpty() ? 'disabled' : '' }}>
                    Salvar Empréstimo
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addItemButton = document.getElementById('add-item');
            const container = document.getElementById('product-items-container');
            const products = @json($products);

            if (addItemButton) {
                addItemButton.addEventListener('click', function () {
                    const selectOptions = products.map(product => `<option value="${product.id}">${product.brand} - ${product.model} - ${product.serial_number}</option>`).join('');

                    const newItemHtml = `
                        <div class="item-group mb-4 p-4 border border-gray-200 rounded-md">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selecione o Produto</label>
                                    <select name="product_id[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                                        <option value="">Selecione...</option>
                                        ${selectOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', newItemHtml);
                });
            }
        });
    </script>
@endpush

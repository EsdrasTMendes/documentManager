@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-4">Detalhes do Empréstimo #{{ $productLoan->id }}</h2>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informações do Empréstimo</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Usuário</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $productLoan->user->name }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Data do Empréstimo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ \Carbon\Carbon::parse($productLoan->loan_date)->format('d/m/Y') }}
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Data Prevista de Devolução</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ \Carbon\Carbon::parse($productLoan->expected_return_date)->format('d/m/Y') }}
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 capitalize">
                            {{ $productLoan->status }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Itens Emprestados</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <ul class="divide-y divide-gray-200">
                    @forelse ($productLoan->productLoanItems as $item)
                        <li class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->product->brand }} - {{ $item->product->model }}</div>
                            <div class="text-sm text-gray-500">Número de Série: {{ $item->product->serial_number }}</div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-gray-500">Nenhum item associado a este empréstimo.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        @if ($productLoan->documents->isNotEmpty())
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 flex gap-4">
                <a href="{{ route('documents.download', ['document' => $productLoan->documents->first(), 'type' => 'docx']) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fa-solid fa-file-word"></i> Download DOCX
                </a>
                <a href="{{ route('documents.download', ['document' => $productLoan->documents->first(), 'type' => 'pdf']) }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </a>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('product_loans.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Voltar
            </a>
        </div>
    </div>
@endsection

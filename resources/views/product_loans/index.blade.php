@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-4">Meus Empréstimos de Equipamentos</h2>

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('product_loans.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Novo Empréstimo
            </a>
        </div>

        @if ($productLoans->isEmpty())
            <div class="text-gray-600">Você ainda não possui empréstimos de equipamentos cadastrados.</div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data do Empréstimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Esperada de Devolução</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($productLoans as $loan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $loan->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('product_loans.show', $loan->id) }}" class="text-indigo-600 hover:text-indigo-900">Detalhes</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

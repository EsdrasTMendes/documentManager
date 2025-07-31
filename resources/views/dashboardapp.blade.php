@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Olá, {{ auth()->user()->name }}</h1>

        <div class="mb-6">
            <a href="{{ route('documents.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Novo Documento
            </a>
        </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('documents.index') }}" class="flex gap-4 flex-wrap">
                <input type="text" name="nome" placeholder="Nome" class="border px-2 py-1 rounded" />
                <input type="text" name="cpf" placeholder="CPF" class="border px-2 py-1 rounded" />
                <input type="text" name="funcao" placeholder="Função" class="border px-2 py-1 rounded" />
                <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded">Filtrar</button>
            </form>
        </div>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">Nome</th>
                <th class="border px-4 py-2">Função</th>
                <th class="border px-4 py-2">CPF</th>
                <th class="border px-4 py-2">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($documents as $document)
                <tr>
                    <td class="border px-4 py-2">{{ $document->nome }}</td>
                    <td class="border px-4 py-2">{{ $document->funcao }}</td>
                    <td class="border px-4 py-2">{{ $document->cpf }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('documents.edit', $document) }}" class="text-blue-600">Editar</a>
                        <a href="{{ route('documents.download', [$document, 'type' => 'pdf']) }}" class="text-green-600">PDF</a>
                        <a href="{{ route('documents.download', [$document, 'type' => 'docx']) }}" class="text-purple-600">DOCX</a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Nenhum documento encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

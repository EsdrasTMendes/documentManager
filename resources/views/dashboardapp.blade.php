@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 sm:mb-0">Dashboard</h1>

            <button id="open-modal-btn" class="bg-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                <i class="fa-solid fa-upload mr-2"></i> Cadastrar Produto (XML)
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg shadow-sm relative mb-6" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg shadow-sm relative mb-6" role="alert">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Meus Empréstimos</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Data do Empréstimo
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Produto
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($productLoans as $loan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    {{ $loan->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @foreach ($loan->productLoanItems as $item)
                                        <span class="font-medium text-indigo-600">{{ $item->product->brand }}</span> - {{ $item->product->model }}
                                        @if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $statusClass = [
                                            'aprovado' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'returned' => 'bg-gray-100 text-gray-800',
                                        ][$loan->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($loan->documents->isNotEmpty())
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('documents.download', ['id' => $loan->documents->first()->id, 'type' => 'pdf']) }}" class="text-red-600 hover:text-red-900 transition duration-200" title="Download PDF">
                                                <i class="fa-solid fa-file-pdf text-lg"></i>
                                            </a>
                                            <a href="{{ route('documents.download', ['id' => $loan->documents->first()->id, 'type' => 'docx']) }}" class="text-blue-600 hover:text-blue-900 transition duration-200" title="Download DOCX">
                                                <i class="fa-solid fa-file-word text-lg"></i>
                                            </a>
                                            {{-- Botão de Editar (agora um botão para abrir a modal) --}}
                                            <button type="button" class="edit-btn text-indigo-600 hover:text-indigo-900 transition duration-200 focus:outline-none" data-doc-id="{{ $loan->documents->first()->id }}" title="Editar">
                                                <i class="fa-solid fa-edit text-lg"></i>
                                            </button>
                                            {{-- Botão de Excluir (Formulário) --}}
                                            <form action="{{ route('documents.destroy', $loan->documents->first()->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-600 hover:text-red-600 transition duration-200 focus:outline-none" title="Excluir">
                                                    <i class="fa-solid fa-trash-alt text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Documento indisponível</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    Nenhum empréstimo encontrado.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal de Cadastro de Produto --}}
        <div id="product-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
            <div class="relative top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6 w-full max-w-lg bg-white rounded-xl shadow-2xl transform transition-transform duration-300 ease-in-out scale-95 opacity-0" id="modal-content">
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Cadastrar Novo Produto (via XML)</h3>
                    <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 text-3xl leading-none focus:outline-none">&times;</button>
                </div>
                <div class="mt-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="invoice_file" class="block text-gray-700 text-sm font-semibold mb-2">
                                Selecione o arquivo XML da Nota Fiscal:
                            </label>
                            <input type="file" name="invoice_file" id="invoice_file" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" required accept=".xml">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-green-700 transition duration-300 ease-in-out transform hover:scale-105">
                                Processar e Criar Empréstimo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal de Edição de Documento (Nova) --}}
        <div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out">
            <div class="relative top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-6 w-full max-w-lg bg-white rounded-xl shadow-2xl transform transition-transform duration-300 ease-in-out scale-95 opacity-0" id="edit-modal-content">
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Editar Documento</h3>
                    <button id="close-edit-modal-btn" class="text-gray-400 hover:text-gray-600 text-3xl leading-none focus:outline-none">&times;</button>
                </div>
                <div class="mt-4">
                    <form id="edit-form" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="edit_invoice_file" class="block text-gray-700 text-sm font-semibold mb-2">
                                Selecione o novo arquivo XML da Nota Fiscal:
                            </label>
                            <input type="file" name="invoice_file" id="edit_invoice_file" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500" required accept=".xml">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:scale-105">
                                Atualizar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('product-modal');
            const modalContent = document.getElementById('modal-content');
            const openBtn = document.getElementById('open-modal-btn');
            const closeBtn = document.getElementById('close-modal-btn');
            const overlay = document.getElementById('product-modal');

            function openModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                modal.classList.remove('opacity-100');
                modalContent.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    closeModal();
                }
            });

            // Script para a nova modal de edição
            const editModal = document.getElementById('edit-modal');
            const editModalContent = document.getElementById('edit-modal-content');
            const editForm = document.getElementById('edit-form');
            const closeEditBtn = document.getElementById('close-edit-modal-btn');
            const overlayEdit = document.getElementById('edit-modal');

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const docId = e.currentTarget.dataset.docId;
                    const updateUrl = `/documents/${docId}/update`;
                    editForm.setAttribute('action', updateUrl);

                    editModal.classList.remove('hidden');
                    setTimeout(() => {
                        editModal.classList.add('opacity-100');
                        editModalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                });
            });

            closeEditBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
                setTimeout(() => {
                    editModal.classList.remove('opacity-100');
                    editModalContent.classList.remove('scale-100', 'opacity-100');
                }, 300);
            });

            overlayEdit.addEventListener('click', (e) => {
                if (e.target === overlayEdit) {
                    editModal.classList.add('hidden');
                    setTimeout(() => {
                        editModal.classList.remove('opacity-100');
                        editModalContent.classList.remove('scale-100', 'opacity-100');
                    }, 300);
                }
            });
        });
    </script>
@endpush

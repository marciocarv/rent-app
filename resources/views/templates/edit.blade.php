<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <h2 class="text-xl font-semibold leading-tight text-blue-900">Editar Modelo: {{ $template->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-xl">

                <form action="{{ route('templates.update', $template) }}" method="POST" id="templateForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-bold text-slate-700">Nome do Modelo</label>
                        <input type="text" name="name" value="{{ old('name', $template->name) }}" required class="block w-full rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mb-4" wire:ignore>
                        <label class="block mb-1 text-sm font-bold text-slate-700">Conteúdo do Contrato</label>
                        <p class="mb-2 text-xs text-slate-500">Variáveis disponíveis: [LOCADOR_NOME], [LOCATARIO_NOME], [IMOVEL_ENDERECO], [VALOR_ALUGUEL], [DATA_INICIO], [DATA_FIM], [DIA_VENCIMENTO]</p>

                        <!-- Hidden input to hold the HTML for Laravel -->
                        <input type="hidden" name="content" id="contentInput" value="{{ $template->content }}">

                        <!-- We inject the raw HTML directly inside the container so Quill picks it up on init -->
                        <div id="editor-container" style="height: 500px; font-size: 16px;">{!! $template->content !!}</div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('templates.index') }}" class="px-4 py-2 text-sm font-bold bg-white border rounded-lg shadow-sm text-slate-700 border-slate-300 hover:bg-slate-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500">Atualizar Modelo</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{'header': [1, 2, 3, false]}],
                        ['bold', 'italic', 'underline'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'align': []}],
                        ['clean']
                    ]
                }
            });

            // On form submit, copy Quill HTML to the hidden input
            document.getElementById('templateForm').addEventListener('submit', function(e) {
                document.getElementById('contentInput').value = quill.root.innerHTML;
            });
        });
    </script>
</x-app-layout>

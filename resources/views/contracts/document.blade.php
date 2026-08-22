<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-blue-900">
            Gerador de Contrato: {{ $contract->tenant->name ?? 'Inquilino' }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="contractGenerator()">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Toolbar -->
            <div class="p-4 mb-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <div class="w-full sm:w-1/2">
                        <label for="template" class="block mb-1 text-sm font-bold text-slate-700">Escolha um Modelo:</label>
                        <select x-model="selectedTemplate" @change="loadTemplate()" id="template" class="block w-full rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Selecione um modelo da sua biblioteca...</option>
                            <template x-for="template in templates" :key="template.id">
                                <option :value="template.id" x-text="template.name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('contracts.index') }}" class="px-4 py-2 text-sm font-bold bg-white border rounded-lg shadow-sm text-slate-700 border-slate-300 hover:bg-slate-50">
                            Voltar
                        </a>
                        <button @click="printDocument()" :disabled="!documentContent" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            Imprimir / Salvar PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Editor Area -->
            <div class="p-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                <p class="mb-4 text-sm text-slate-500">
                    Você pode editar o texto abaixo livremente antes de imprimir. As variáveis automáticas já foram preenchidas.
                </p>
                <textarea
                    x-model="documentContent"
                    rows="25"
                    class="block w-full p-4 font-mono text-sm leading-relaxed rounded-md shadow-inner bg-slate-50 border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Selecione um modelo acima ou digite o contrato aqui..."></textarea>
            </div>

        </div>
    </div>

    <!-- Alpine.js Logic for Template Swapping -->
    <script>
        function contractGenerator() {
            return {
                templates: @json($templates),
                variables: @json($variables),
                selectedTemplate: '',
                documentContent: '',

                loadTemplate() {
                    if (!this.selectedTemplate) {
                        this.documentContent = '';
                        return;
                    }

                    // Find the selected template
                    let template = this.templates.find(t => t.id == this.selectedTemplate);

                    if (template) {
                        let content = template.content;

                        // Replace all [VARIABLES] with actual contract data
                        for (const [key, value] of Object.entries(this.variables)) {
                            content = content.replaceAll(key, value);
                        }

                        this.documentContent = content;
                    }
                },

                printDocument() {
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                        <html>
                            <head>
                                <title>Contrato de Locação</title>
                                <style>
                                    body { font-family: Arial, sans-serif; padding: 40px; line-height: 1.6; color: #333; }
                                    pre { font-family: Arial, sans-serif; white-space: pre-wrap; font-size: 14px; }
                                </style>
                            </head>
                            <body>
                                <pre>${this.documentContent}</pre>
                            </body>
                        </html>
                    `);
                    printWindow.document.close();

                    // Small delay to ensure styles load before print dialog
                    setTimeout(() => {
                        printWindow.print();
                    }, 250);
                }
            }
        }
    </script>
</x-app-layout>

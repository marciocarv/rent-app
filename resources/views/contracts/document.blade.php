<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-blue-900">
                Documento do Contrato: {{ $contract->tenant->name ?? 'Inquilino' }}
            </h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ $contract->status === \App\Enums\ContractStatus::Draft ? 'bg-slate-200 text-slate-700' : 'bg-amber-100 text-amber-700' }}">
                Status: {{ $contract->status->label() }}
            </span>
        </div>
    </x-slot>

    <div class="py-12" x-data="contractGenerator()">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Toolbar -->
            <div class="p-4 mb-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

                    <div class="w-full sm:w-1/2">
                        @if($contract->status === \App\Enums\ContractStatus::Draft)
                            <label for="template" class="block mb-1 text-sm font-bold text-slate-700">Escolha um Modelo:</label>
                            <select x-model="selectedTemplate" @change="loadTemplate()" id="template" class="block w-full rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Selecione um modelo da sua biblioteca...</option>
                                <template x-for="template in templates" :key="template.id">
                                    <option :value="template.id" x-text="template.name"></option>
                                </template>
                            </select>
                            @if($templates->isEmpty())
                                <form action="{{ route('templates.defaults') }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-blue-600 transition-colors hover:text-blue-800 hover:underline">
                                        + Criar Modelos de Contrato Padrão Automaticamente
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="p-3 text-sm border rounded-lg bg-amber-50 text-amber-800 border-amber-200">
                                <strong>Documento Bloqueado:</strong> Este contrato já foi finalizado e seu conteúdo original foi congelado para assinatura digital.
                                <br><span class="block mt-1 font-mono text-xs text-amber-600">Hash SHA-256: {{ substr($contract->document_hash, 0, 16) }}...</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button @click="printDocument()" :disabled="!documentContent" class="px-4 py-2 text-sm font-bold bg-white border rounded-lg shadow-sm text-slate-700 border-slate-300 hover:bg-slate-50 disabled:opacity-50">
                            Imprimir PDF
                        </button>

                        @if($contract->status === \App\Enums\ContractStatus::Draft)
                            <button @click="finalizeDocument()" :disabled="!documentContent" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                Salvar e Solicitar Assinaturas
                            </button>
                        @elseif($contract->status === \App\Enums\ContractStatus::PendingSignatures)

                            <!-- Landlord Signature Section -->
                            @if(!$contract->landlord_signed_at)
                                <form action="{{ route('contracts.document.sign-landlord', $contract) }}" method="POST" class="inline" onsubmit="return confirm('ATENÇÃO: Ao confirmar, seu endereço IP e o horário atual serão registrados no banco de dados como sua assinatura digital, possuindo validade legal. Deseja prosseguir?');">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-green-600 rounded-lg shadow-sm hover:bg-green-500">
                                        Assinar Contrato
                                    </button>
                                </form>
                            @else
                                <div class="flex items-center px-4 py-2 text-sm font-bold text-green-800 bg-green-100 border border-green-200 rounded-lg shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Você assinou em {{ $contract->landlord_signed_at->format('d/m/Y \à\s H:i') }}
                                </div>
                            @endif

                        @endif
                    </div>
                </div>
            </div>

            <!-- Hidden Form for Finalization -->
            <form id="finalizeForm" action="{{ route('contracts.document.finalize', $contract) }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="document_body" id="document_body_input">
            </form>

            <!-- Editor Area -->
            <!-- Editor Area -->
            <div class="p-6 bg-white border shadow-sm border-slate-100 rounded-xl" wire:ignore>
                <div class="bg-white">
                    <div id="editor-container" style="height: 600px; font-size: 16px;"></div>
                </div>
            </div>

            <!-- Digital Signature Certificate (Only visible after finalizing) -->
            @if($contract->status !== \App\Enums\ContractStatus::Draft && ($contract->landlord_signed_at || $contract->tenant_signed_at))
                <div class="p-6 mt-6 border rounded-xl bg-slate-50 border-slate-200">
                    <h3 class="mb-4 text-sm font-bold text-center text-slate-700">CERTIFICADO DE ASSINATURAS ELETRÔNICAS</h3>

                    <p class="mb-4 font-mono text-xs text-center break-all text-slate-500">
                        <strong>Hash de Validação do Documento (SHA-256):</strong><br>
                        {{ $contract->document_hash }}
                    </p>

                    <div class="space-y-3 font-mono text-sm text-slate-700">
                        <!-- Landlord Signature -->
                        @if($contract->landlord_signed_at)
                            <div class="p-4 bg-white border rounded-lg shadow-sm border-slate-200">
                                <span class="font-bold text-green-600">✓</span> Documento assinado digitalmente por <strong>{{ $contract->landlord->name }}</strong> (Locador)<br>
                                <span class="pl-5 text-xs text-slate-500">Data e Hora: {{ $contract->landlord_signed_at->format('d/m/Y \à\s H:i:s') }} | Endereço IP: {{ $contract->landlord_sign_ip }}</span>
                            </div>
                        @endif

                        <!-- Tenant Signature -->
                        @if($contract->tenant_signed_at)
                            <div class="p-4 bg-white border rounded-lg shadow-sm border-slate-200">
                                <span class="font-bold text-green-600">✓</span> Documento assinado digitalmente por <strong>{{ $contract->tenant->name }}</strong> (Locatário)<br>
                                <span class="pl-5 text-xs text-slate-500">Data e Hora: {{ $contract->tenant_signed_at->format('d/m/Y \à\s H:i:s') }} | Endereço IP: {{ $contract->tenant_sign_ip }}</span>
                            </div>
                        @elseif($contract->status !== \App\Enums\ContractStatus::Draft)
                            <div class="p-4 bg-white border border-dashed rounded-lg shadow-sm border-slate-300">
                                <span class="font-bold text-amber-500">⏳</span> Aguardando assinatura digital de <strong>{{ $contract->tenant->name }}</strong> (Locatário)
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Include Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Alpine.js Logic -->
    <script>
        function contractGenerator() {
            return {
                templates: @json($templates),
                variables: @json($variables),
                isLocked: @json($contract->status !== \App\Enums\ContractStatus::Draft),
                savedDocument: @json($contract->document_body),
                selectedTemplate: '',
                documentContent: '',
                quill: null,

                init() {
                    this.quill = new Quill('#editor-container', {
                        theme: 'snow',
                        readOnly: this.isLocked,
                        placeholder: this.isLocked ? '' : 'Selecione um modelo acima ou comece a digitar seu contrato aqui...',
                        modules: {
                            toolbar: this.isLocked ? false : [
                                [{'header': [1, 2, 3, false]}],
                                ['bold', 'italic', 'underline'],
                                [{'list': 'ordered'}, {'list': 'bullet'}],
                                [{'align': []}],
                                ['clean']
                            ]
                        }
                    });

                    if (this.savedDocument) {
                        this.quill.root.innerHTML = this.savedDocument;
                        this.documentContent = this.savedDocument;
                    }

                    this.quill.on('text-change', () => {
                        this.documentContent = this.quill.root.innerHTML;
                    });
                },

                loadTemplate() {
                    if (this.isLocked || !this.selectedTemplate) {
                        this.quill.root.innerHTML = '';
                        this.documentContent = '';
                        return;
                    }

                    let template = this.templates.find(t => t.id == this.selectedTemplate);

                    if (template) {
                        let content = template.content;
                        for (const [key, value] of Object.entries(this.variables)) {
                            content = content.replaceAll(key, value);
                        }
                        this.quill.root.innerHTML = content;
                        this.documentContent = content;
                    }
                },

                finalizeDocument() {
                    if(confirm('Tem certeza? Após finalizar, o texto do contrato será bloqueado com um Hash de segurança e não poderá mais ser editado.')) {
                        document.getElementById('document_body_input').value = this.documentContent;
                        document.getElementById('finalizeForm').submit();
                    }
                },

                printDocument() {
                    // Generate the digital signature stamp dynamically for the PDF
                    let signatureBlock = '';
                    @if($contract->status !== \App\Enums\ContractStatus::Draft && ($contract->landlord_signed_at || $contract->tenant_signed_at))
                        signatureBlock = `
                            <div style="margin-top: 60px; padding: 20px; border: 2px solid #ddd; background-color: #fcfcfc; font-family: 'Courier New', Courier, monospace; font-size: 12px; page-break-inside: avoid;">
                                <h4 style="margin-top: 0; text-align: center; text-transform: uppercase;">Certificado de Assinaturas Eletrônicas</h4>
                                <p style="text-align: center; word-break: break-all; margin-bottom: 20px;">
                                    <strong>Hash de Validação (SHA-256):</strong><br>
                                    {{ $contract->document_hash }}
                                </p>
                                <ul style="list-style-type: none; padding-left: 0; margin: 0;">
                                    @if($contract->landlord_signed_at)
                                        <li style="margin-bottom: 10px; padding: 10px; border: 1px solid #eee; background: #fff;">
                                            <strong>&#10003; Documento assinado digitalmente por {{ $contract->landlord->name }} (Locador)</strong><br>
                                            Data e Hora: {{ $contract->landlord_signed_at->format('d/m/Y \à\s H:i:s') }}<br>
                                            Endereço IP: {{ $contract->landlord_sign_ip }}
                                        </li>
                                    @endif
                                    @if($contract->tenant_signed_at)
                                        <li style="margin-bottom: 10px; padding: 10px; border: 1px solid #eee; background: #fff;">
                                            <strong>&#10003; Documento assinado digitalmente por {{ $contract->tenant->name }} (Locatário)</strong><br>
                                            Data e Hora: {{ $contract->tenant_signed_at->format('d/m/Y \à\s H:i:s') }}<br>
                                            Endereço IP: {{ $contract->tenant_sign_ip }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        `;
                    @endif

                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                        <html>
                            <head>
                                <title>Contrato de Locação</title>
                                <style>
                                    body { font-family: 'Times New Roman', Times, serif; padding: 40px; line-height: 1.6; color: #000; max-width: 800px; margin: 0 auto; }
                                    h1, h2, h3 { text-align: center; font-weight: bold; }
                                    p { margin-bottom: 15px; text-align: justify; }
                                    ul, ol { margin-bottom: 15px; }
                                    li { margin-bottom: 5px; }
                                </style>
                            </head>
                            <body>
                                ${this.documentContent}
                                ${signatureBlock}
                            </body>
                        </html>
                    `);
                    printWindow.document.close();
                    setTimeout(() => printWindow.print(), 250);
                }
            }
        }
    </script>
</x-app-layout>

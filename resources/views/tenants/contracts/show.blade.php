<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-blue-900">
                Visualizar Contrato
            </h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ $contract->status === \App\Enums\ContractStatus::Active ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                Status: {{ $contract->status->label() }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Signature Action Panel -->
            @if($contract->status === \App\Enums\ContractStatus::PendingSignatures && !$contract->tenant_signed_at)
                <div class="p-6 mb-6 bg-white border shadow-sm rounded-xl border-amber-200">
                    <h3 class="mb-2 text-lg font-bold text-slate-800">Assinatura Pendente</h3>
                    <p class="mb-4 text-sm text-slate-600">Por favor, leia o contrato abaixo atentamente. Ao clicar em assinar, seu endereço de IP e o horário atual serão registrados com validade legal.</p>

                    <form action="{{ route('tenant.contracts.sign', $contract) }}" method="POST" onsubmit="return confirm('Confirmo que li e estou de acordo com os termos do contrato. Desejo assinar digitalmente.');">
                        @csrf
                        <button type="submit" class="px-6 py-2 font-bold text-white transition-colors bg-green-600 rounded-lg shadow hover:bg-green-500">
                            Assinar Contrato
                        </button>
                    </form>
                </div>
            @endif

            <!-- The Frozen Document -->
            <div class="p-8 bg-white border shadow-sm border-slate-200 rounded-xl">
                <!-- Contract Body -->
                <div class="prose text-justify max-w-none" style="font-family: 'Times New Roman', Times, serif;">
                    {!! $contract->document_body !!}
                </div>

                <!-- Digital Certificate Block -->
                <div class="p-6 mt-12 border bg-slate-50 border-slate-200 rounded-xl">
                    <h3 class="mb-4 text-sm font-bold text-center uppercase text-slate-700">Certificado de Assinaturas Eletrônicas</h3>
                    <p class="mb-4 font-mono text-xs text-center break-all text-slate-500">
                        <strong>Hash de Validação (SHA-256):</strong><br>
                        {{ $contract->document_hash }}
                    </p>

                    <div class="space-y-3 font-mono text-sm text-slate-700">
                        @if($contract->landlord_signed_at)
                            <div class="p-3 bg-white border rounded-lg border-slate-200">
                                <span class="text-green-600">✓</span> Assinado por <strong>{{ $contract->landlord->name }}</strong> (Locador)<br>
                                <span class="pl-5 text-xs text-slate-500">{{ $contract->landlord_signed_at->format('d/m/Y \à\s H:i:s') }} | IP: {{ $contract->landlord_sign_ip }}</span>
                            </div>
                        @endif

                        @if($contract->tenant_signed_at)
                            <div class="p-3 bg-white border rounded-lg border-slate-200">
                                <span class="text-green-600">✓</span> Assinado por <strong>{{ $contract->tenant->name }}</strong> (Locatário)<br>
                                <span class="pl-5 text-xs text-slate-500">{{ $contract->tenant_signed_at->format('d/m/Y \à\s H:i:s') }} | IP: {{ $contract->tenant_sign_ip }}</span>
                            </div>
                        @else
                            <div class="p-3 bg-white border border-dashed rounded-lg border-slate-300">
                                <span class="text-amber-500">⏳</span> Aguardando sua assinatura...
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

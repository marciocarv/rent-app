<div x-data="{ isTicketModalOpen: false }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-blue-900">
                {{ __('Meu Imóvel') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="px-4 py-3 mb-6 border rounded-lg bg-emerald-50 border-emerald-200 text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Active Contract Info -->
                @if($contract)
                    <div class="flex items-center justify-between p-6 mb-8 bg-white border shadow-sm rounded-xl border-slate-100">
                        <div>
                            <p class="mb-1 text-sm font-bold tracking-wider uppercase {{ $contract->status === \App\Enums\ContractStatus::PendingSignatures ? 'text-amber-600' : 'text-slate-500' }}">
                                {{ $contract->status === \App\Enums\ContractStatus::PendingSignatures ? 'Aguardando Sua Assinatura' : 'Contrato Ativo' }}
                            </p>
                            <h3 class="text-2xl font-extrabold text-blue-900">
                                {{ $contract->unit?->property?->name ?? 'Imóvel' }} - {{ $contract->unit?->name ?? 'Unidade' }}
                            </h3>
                            <p class="mt-1 text-sm text-slate-600">Locador: {{ $contract->landlord->name }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Contract Action Button -->
                            <a href="{{ route('tenant.contracts.show', $contract) }}"
                               class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-colors
                               {{ $contract->status === \App\Enums\ContractStatus::PendingSignatures && !$contract->tenant_signed_at
                                    ? 'bg-amber-500 hover:bg-amber-400 text-white animate-pulse'
                                    : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>

                                {{ $contract->status === \App\Enums\ContractStatus::PendingSignatures && !$contract->tenant_signed_at
                                    ? 'Assinar Contrato'
                                    : 'Ver Contrato' }}
                            </a>

                            <!-- Ticket Button -->
                            <button @click="isTicketModalOpen = true" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:bg-blue-500 transition-colors">
                                + Abrir Chamado
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-6 mb-8 border bg-amber-50 text-amber-800 rounded-xl border-amber-200">
                        Você não possui nenhum contrato de aluguel ativo no momento.
                    </div>
                @endif

                <!-- Tickets List -->
                <div class="overflow-hidden bg-white border shadow-sm sm:rounded-xl border-slate-100">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-blue-900">Meus Chamados de Manutenção</h3>
                    </div>
                    <div class="p-6">
                        @if($tickets->isEmpty())
                            <p class="py-4 text-center text-slate-500">Você ainda não abriu nenhum chamado.</p>
                        @else
                            <div class="grid gap-4">
                                @foreach($tickets as $ticket)
                                    <div class="flex items-center justify-between p-4 border rounded-lg border-slate-200">
                                        <div>
                                            <h4 class="font-bold text-slate-800">{{ $ticket->title }}</h4>
                                            <p class="mt-1 text-sm text-slate-500">{{ $ticket->description }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $ticket->status->value === 'open' ? 'bg-amber-100 text-amber-800' : ($ticket->status->value === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                                                {{ $ticket->status->label() }}
                                            </span>
                                            <p class="mt-2 text-xs text-slate-400">{{ $ticket->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-app-layout>

    <!-- Modal for New Ticket -->
    <div x-show="isTicketModalOpen" class="relative z-50" style="display: none;">
        <div x-show="isTicketModalOpen" x-transition.opacity class="fixed inset-0 bg-opacity-75 bg-slate-900"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div @click.outside="isTicketModalOpen = false" class="relative overflow-hidden text-left transition-all transform bg-white shadow-xl rounded-xl sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ route('tenant.tickets.store') }}" method="POST">
                        @csrf
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <h3 class="mb-4 text-lg font-bold leading-6 text-blue-900">Solicitar Manutenção</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">O que aconteceu? *</label>
                                    <input type="text" name="title" required placeholder="Ex: Vazamento na pia da cozinha" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Detalhes *</label>
                                    <textarea name="description" required rows="3" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Descreva o problema com detalhes..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Prioridade *</label>
                                    <select name="priority" required class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        @foreach(\App\Enums\TicketPriority::cases() as $priority)
                                            <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-slate-50 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Enviar Solicitação</button>
                            <button type="button" @click="isTicketModalOpen = false" class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold bg-white rounded-md shadow-sm text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

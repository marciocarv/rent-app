<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Visão Geral') }}
        </h2>
    </x-slot>

    <!-- Welcome Alert -->
    <div class="flex items-center justify-between p-6 mb-8 bg-white border shadow-sm rounded-xl border-slate-100">
        <div>
            <h3 class="text-lg font-bold text-blue-900">Olá, {{ Auth::user()->name }}! 👋</h3>
            <p class="mt-1 text-sm text-slate-500">Bem-vindo ao painel do Rent.app. Aqui está o resumo da sua carteira de imóveis.</p>
        </div>
        <div class="hidden md:block">
            <a href="{{ route('contracts.create') ?? '#' }}" class="px-4 py-2 text-sm font-bold text-white transition-colors rounded-lg shadow-sm bg-emerald-600 hover:bg-emerald-500">
                + Novo Contrato
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">

        <!-- Stat Card 1: Properties / Units -->
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-slate-500">Imóveis / Unidades</p>
                    <p class="text-3xl font-extrabold text-blue-900">{{ $propertiesCount }} <span class="text-lg font-medium text-slate-400">/ {{ $unitsCount }}</span></p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 text-blue-600 rounded-full bg-blue-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 2: Tenants -->
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-slate-500">Inquilinos Registrados</p>
                    <p class="text-3xl font-extrabold text-blue-900">{{ $tenantsCount }}</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Open Tickets -->
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-slate-500">Chamados Abertos</p>
                    <p class="text-3xl font-extrabold text-blue-900">{{ $openTicketsCount }}</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 4: Expected Revenue -->
        <div class="p-6 bg-white border shadow-sm rounded-xl border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="mb-1 text-sm font-medium text-slate-500">Receita Esperada (Mês)</p>
                    <p class="text-2xl font-extrabold text-blue-900">R$ {{ number_format($expectedRevenue, 2, ',', '.') }}</p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Content Area: Contracts and Maintenances -->
    @if($propertiesCount === 0 && $recentContracts->isEmpty())
        <!-- Onboarding / Empty State (Only shows if they have zero properties) -->
        <div class="p-8 text-center bg-white border shadow-sm rounded-xl border-slate-100">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-slate-100 text-slate-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="mb-2 text-lg font-bold text-blue-900">Nenhum imóvel cadastrado</h3>
            <p class="max-w-sm mx-auto mb-6 text-slate-500">Você ainda não gerou nenhum contrato de locação. Comece cadastrando um imóvel e um inquilino.</p>

            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('properties.create') ?? '#' }}" class="w-full px-6 py-2 font-bold transition-colors border rounded-lg sm:w-auto border-slate-300 text-slate-700 hover:bg-slate-50">
                    Cadastrar Imóvel
                </a>
                <a href="{{ route('tenants.create') ?? '#' }}" class="w-full px-6 py-2 font-bold text-white transition-colors bg-blue-900 rounded-lg shadow-sm sm:w-auto hover:bg-blue-800">
                    Cadastrar Inquilino
                </a>
            </div>
        </div>
    @else
        <!-- Grid for Recent Data -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

            <!-- Recent Contracts -->
            <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-100">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-blue-900">Contratos Recentes</h3>
                    <a href="{{ route('contracts.index') ?? '#' }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
                </div>
                <div class="p-6">
                    @forelse($recentContracts as $contract)
                        <div class="flex items-center justify-between pb-4 mb-4 border-b last:mb-0 last:pb-0 last:border-0 border-slate-50">
                            <div>
                                <p class="font-bold text-slate-800">{{ $contract->tenant?->name ?? 'Sem Inquilino' }}</p>
                                <p class="text-sm text-slate-500">{{ $contract->unit?->property?->name ?? 'Imóvel' }} - {{ $contract->unit?->name ?? 'Unidade' }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">
                                {{ ucfirst($contract->status->value ?? 'Ativo') }}
                            </span>
                        </div>
                    @empty
                        <p class="py-4 text-sm text-center text-slate-500">Nenhum contrato ativo.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Maintenances -->
            <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-100">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-blue-900">Últimas Manutenções</h3>
                    <a href="{{ route('tickets.index') ?? '#' }}" class="text-sm text-blue-600 hover:underline">Ver todas</a>
                </div>
                <div class="p-6">
                    @forelse($recentTickets as $ticket)
                        <div class="flex items-center justify-between pb-4 mb-4 border-b last:mb-0 last:pb-0 last:border-0 border-slate-50">
                            <div>
                                <p class="font-bold text-slate-800">{{ $ticket->subject ?? $ticket->title ?? 'Chamado #' . $ticket->id }}</p>
                                <p class="text-sm text-slate-500">Aberto por: {{ $ticket->tenant?->name ?? 'Desconhecido' }}</p>
                            </div>

                            @php
                                $statusValue = is_object($ticket->status) ? $ticket->status->value : $ticket->status;
                                $statusLabel = is_object($ticket->status) && method_exists($ticket->status, 'label')
                                    ? $ticket->status->label()
                                    : ucfirst($statusValue);
                            @endphp

                            @if($statusValue === 'open')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700">
                                    {{ $statusLabel }}
                                </span>
                            @elseif($statusValue === 'in_progress')
                                <span class="px-3 py-1 text-xs font-bold text-blue-700 bg-blue-100 rounded-full">
                                    {{ $statusLabel }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">
                                    {{ $statusLabel }}
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="py-4 text-sm text-center text-slate-500">Nenhuma manutenção registrada.</p>
                    @endforelse
                </div>
            </div>

        </div>
    @endif
</x-app-layout>

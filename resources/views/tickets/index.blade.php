<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-blue-900">
            {{ __('Gestão de Manutenção') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="flex items-center px-4 py-3 mb-6 border rounded-lg shadow-sm bg-emerald-50 border-emerald-200 text-emerald-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white border shadow-sm sm:rounded-xl border-slate-100">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-blue-900">Chamados dos Inquilinos</h3>
                    <p class="text-sm text-slate-500">Acompanhe e gerencie as solicitações de reparo nos seus imóveis.</p>
                </div>

                <div class="p-6">
                    @if($tickets->isEmpty())
                        <div class="py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-slate-50 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="mb-2 text-lg font-bold text-blue-900">Nenhum chamado aberto</h3>
                            <p class="text-slate-500">Tudo funcionando perfeitamente em seus imóveis!</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6">
                            @foreach ($tickets as $ticket)
                                <div class="border {{ $ticket->status->value === 'resolved' ? 'border-slate-200 bg-slate-50/50 opacity-75' : 'border-blue-100 bg-white shadow-sm' }} rounded-xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all">

                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-extrabold text-slate-800">{{ $ticket->title }}</h4>
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold
                                                {{ $ticket->priority->value === 'emergency' ? 'bg-red-100 text-red-800' : ($ticket->priority->value === 'high' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-600') }}">
                                                {{ $ticket->priority->label() }}
                                            </span>
                                        </div>

                                        <p class="mb-3 text-sm text-slate-600">{{ $ticket->description }}</p>

                                        <div class="flex flex-wrap gap-4 text-xs font-medium text-slate-500">
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $ticket->tenant->name }}</span>
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>{{ $ticket->unit->property->name }} - {{ $ticket->unit->name }}</span>
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ $ticket->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="p-4 mt-4 border rounded-lg md:mt-0 md:ml-6 shrink-0 bg-slate-50 border-slate-200">
                                        <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label class="text-xs font-bold tracking-wider uppercase text-slate-500">Status Atual</label>
                                            <select name="status" onchange="this.form.submit()" class="text-sm rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-bold
                                                {{ $ticket->status->value === 'open' ? 'text-amber-600 bg-amber-50' : ($ticket->status->value === 'in_progress' ? 'text-blue-600 bg-blue-50' : 'text-emerald-600 bg-emerald-50') }}">
                                                @foreach(\App\Enums\TicketStatus::cases() as $status)
                                                    <option value="{{ $status->value }}" {{ $ticket->status === $status ? 'selected' : '' }}>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
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

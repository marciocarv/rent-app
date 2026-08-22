<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('properties.index') }}" class="text-slate-400 hover:text-blue-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                    {{ $property->name }}
                </h2>
            </div>

            <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1.5 rounded-full">
                {{ $property->type->label() }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 mb-8 p-6 md:p-8">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mr-4 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Endereço</h3>
                        <p class="text-slate-600 mt-1">{{ $property->address }}</p>

                        @if($property->notes)
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <h4 class="text-sm font-bold text-slate-700 mb-1">Observações</h4>
                                <p class="text-sm text-slate-500">{{ $property->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-extrabold text-blue-900">Unidades deste Imóvel ({{ $property->units->count() }})</h3>
                <a href="{{ route('units.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-emerald-500 transition-colors">
                    + Adicionar Unidade
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($property->units as $unit)
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-lg font-extrabold text-slate-800">{{ $unit->name }}</h4>

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $unit->status->value === 'vacant' ? 'bg-green-100 text-green-800' : ($unit->status->value === 'occupied' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $unit->status->label() }}
                                </span>
                            </div>

                            <div class="flex gap-4 text-sm text-slate-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    {{ $unit->bedrooms ?? 0 }} Quartos
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    {{ $unit->bathrooms ?? 0 }} Banheiros
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <form action="{{ route('units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta unidade?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold transition-colors">Excluir Unidade</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-sm border border-slate-100 p-8 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 mb-3 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </div>
                        <p class="text-slate-500">Este imóvel ainda não possui unidades cadastradas.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>

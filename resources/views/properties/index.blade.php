<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                {{ __('Meus Imóveis') }}
            </h2>
            <a href="{{ route('properties.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-emerald-500 transition-colors">
                + Novo Imóvel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100">
                <div class="p-6 md:p-8">

                    @if($properties->isEmpty())
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Nenhum imóvel cadastrado</h3>
                            <p class="text-slate-500 mb-6">Você ainda não adicionou nenhum imóvel ao seu portfólio.</p>
                            <a href="{{ route('properties.create') }}" class="inline-flex items-center text-emerald-600 font-bold hover:text-emerald-700">
                                Comece cadastrando agora &rarr;
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($properties as $property)
                                <div class="border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow bg-slate-50/50">
                                    <div>
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-extrabold text-blue-900">{{ $property->name }}</h3>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-full">
                                                {{ $property->units_count }} {{ $property->units_count === 1 ? 'Unidade' : 'Unidades' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-500 flex items-start mt-2">
                                            <svg class="w-4 h-4 mr-1 mt-0.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $property->address }}
                                        </p>
                                    </div>

                                    <div class="mt-6 flex justify-between items-center border-t border-slate-200 pt-4">
                                        <div class="flex space-x-3 items-center">
                                            <a href="{{ route('properties.show', $property) }}" class="text-emerald-600 hover:text-emerald-800 text-sm font-bold transition-colors">
                                                Ver Unidades
                                            </a>

                                            <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold transition-colors">Editar</a>

                                            <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este imóvel? Todas as unidades associadas também serão apagadas!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold transition-colors">Excluir</button>
                                            </form>
                                        </div>
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

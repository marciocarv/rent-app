<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Minhas Unidades') }}
            </h2>
            <a href="{{ route('units.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                + Nova Unidade
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($units->isEmpty())
                        <div class="py-8 text-center text-gray-500">
                            Nenhuma unidade encontrada. Adicione uma unidade para poder alugá-la!
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($units as $unit)
                                <div class="flex flex-col justify-between p-4 border rounded-lg shadow-sm">
                                    <div>
                                        <div class="mb-1 text-xs font-bold tracking-wide text-indigo-600 uppercase">
                                            {{ $unit->property->name }}
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $unit->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $unit->bedrooms ?? 0 }} Quartos • {{ $unit->bathrooms ?? 0 }} Banheiros
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between pt-4 mt-4 border-t">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $unit->status->value === 'vacant' ? 'bg-green-100 text-green-800' : ($unit->status->value === 'occupied' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $unit->status->label() }}
                                        </span>

                                        <form action="{{ route('units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta unidade?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900">Excluir</button>
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

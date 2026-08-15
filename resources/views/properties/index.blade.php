<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Meus Imóveis') }}
            </h2>
            <a href="{{ route('properties.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                + Novo Imóvel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Mensagem de Sucesso -->
            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($properties->isEmpty())
                        <div class="py-8 text-center text-gray-500">
                            Você ainda não adicionou nenhum imóvel. Clique no botão acima para começar!
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($properties as $property)
                                <div class="flex flex-col justify-between p-4 border rounded-lg shadow-sm">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $property->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $property->address }}</p>
                                    </div>

                                    <div class="flex items-center justify-between pt-4 mt-4 border-t">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $property->type->label() }}
                                        </span>

                                        <div class="flex space-x-2">
                                            <!-- Botão Editar -->
                                            <a href="{{ route('properties.edit', $property) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Editar</a>

                                            <!-- Botão Excluir -->
                                            <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este imóvel?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-2 text-sm font-medium text-red-600 hover:text-red-900">Excluir</button>
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

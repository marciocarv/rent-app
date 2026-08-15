<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Adicionar Novo Imóvel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <form action="{{ route('properties.store') }}" method="POST">
                    @csrf

                    <!-- Nome do Imóvel -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Imóvel</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ex: Residencial Girassol ou Casa da Praia"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Endereço -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Endereço</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required placeholder="Rua, Número, Bairro, Cidade - Estado"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tipo de Imóvel -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Imóvel</label>
                        <select name="type" id="type" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Selecione um tipo...</option>
                            @foreach(\App\Enums\PropertyType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Observações -->
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Observações (Opcional)</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Informações adicionais relevantes sobre o imóvel..."
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        @error('notes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end">
                        <a href="{{ route('properties.index') }}" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Salvar Imóvel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Adicionar Nova Unidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <form action="{{ route('units.store') }}" method="POST">
                    @csrf

                    <!-- Selecionar Imóvel -->
                    <div class="mb-4">
                        <label for="property_id" class="block text-sm font-medium text-gray-700">Imóvel (Propriedade)</label>
                        <select name="property_id" id="property_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Selecione a qual imóvel esta unidade pertence...</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('property_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nome da Unidade -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Identificação da Unidade</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ex: Apartamento 101, Casa Principal, Sala Comercial 2"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Quartos -->
                        <div class="mb-4">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Quartos</label>
                            <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms') }}" min="0"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Banheiros -->
                        <div class="mb-4">
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Banheiros</label>
                            <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms') }}" min="0"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Atual</label>
                        <select name="status" id="status" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(\App\Enums\UnitStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', 'vacant') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('units.index') }}" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Salvar Unidade</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

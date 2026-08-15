<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Novo Contrato de Aluguel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <form action="{{ route('contracts.store') }}" method="POST">
                    @csrf

                    <!-- Selecionar Unidade -->
                    <div class="mb-4">
                        <label for="unit_id" class="block text-sm font-medium text-gray-700">Unidade (Apenas unidades vagas)</label>
                        <select name="unit_id" id="unit_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Selecione uma unidade...</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->property->name }} - {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Selecionar Inquilino -->
                    <div class="mb-4">
                        <label for="tenant_id" class="block text-sm font-medium text-gray-700">Inquilino</label>
                        <select name="tenant_id" id="tenant_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Selecione um inquilino...</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }} ({{ $tenant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('tenant_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Data de Início -->
                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Data de Início</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('start_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Data de Término -->
                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Data de Término</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('end_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Valor do Aluguel -->
                        <div class="mb-4">
                            <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Valor do Aluguel Mensal (R$)</label>
                            <input type="number" step="0.01" name="monthly_rent" id="monthly_rent" value="{{ old('monthly_rent') }}" required placeholder="Ex: 1500.00"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('monthly_rent') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Caução / Depósito -->
                        <div class="mb-4">
                            <label for="security_deposit" class="block text-sm font-medium text-gray-700">Valor da Caução (R$)</label>
                            <input type="number" step="0.01" name="security_deposit" id="security_deposit" value="{{ old('security_deposit', 0) }}" required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('security_deposit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('contracts.index') }}" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Salvar Contrato</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

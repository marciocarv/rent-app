<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-blue-900">
            {{ __('Cadastrar Novo Imóvel') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white border shadow-sm sm:rounded-xl border-slate-100 md:p-8">

                <!-- Alpine.js State -->
                <form action="{{ route('properties.store') }}" method="POST"
                      x-data="{
                          isMultiUnit: 'no',
                          units: [{ id: Date.now(), name: '', bedrooms: 0, bathrooms: 0, status: 'vacant' }]
                      }">
                    @csrf

                    <!-- ERROS DE VALIDAÇÃO -->
                    @if ($errors->any())
                        <div class="px-4 py-3 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50">
                            <ul class="text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="pb-2 mb-6 text-lg font-bold text-blue-900 border-b">Detalhes do Imóvel</h3>

                    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Nome de Identificação *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ex: Residencial Flores"
                                   class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <!-- Tipo do Imóvel (As suas 3 opções do banco) -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700">Tipo de Imóvel *</label>
                            <select name="type" id="type" required class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="" disabled selected>Selecione...</option>
                                @foreach(\App\Enums\PropertyType::cases() as $type)
                                    <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Endereço (Ocupa linha toda) -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-slate-700">Endereço Completo *</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required placeholder="Rua, Número, Bairro, Cidade - Estado"
                                   class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <h3 class="pb-2 mb-4 text-lg font-bold text-blue-900 border-b">Estrutura e Unidades</h3>

                    <!-- Toggle Estrutural -->
                    <div class="flex flex-col gap-4 mb-6 sm:flex-row">
                        <label class="flex items-center flex-1 p-4 transition-colors border rounded-lg cursor-pointer"
                               :class="isMultiUnit === 'no' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="is_multi_unit" value="no" x-model="isMultiUnit" class="text-emerald-600 focus:ring-emerald-500">
                            <div class="ml-3">
                                <span class="block font-bold text-blue-900">Imóvel de Unidade Única</span>
                                <span class="block text-xs text-slate-500">Alugado inteiro (ex: uma casa).</span>
                            </div>
                        </label>

                        <label class="flex items-center flex-1 p-4 transition-colors border rounded-lg cursor-pointer"
                               :class="isMultiUnit === 'yes' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:bg-slate-50'">
                            <input type="radio" name="is_multi_unit" value="yes" x-model="isMultiUnit" class="text-emerald-600 focus:ring-emerald-500">
                            <div class="ml-3">
                                <span class="block font-bold text-blue-900">Múltiplas Unidades</span>
                                <span class="block text-xs text-slate-500">Possui divisões (ex: prédio, vila, kitnets).</span>
                            </div>
                        </label>
                    </div>

                    <!-- Layout: IMÓVEL ÚNICO -->
                    <div x-show="isMultiUnit === 'no'" x-collapse class="p-6 mb-8 border rounded-lg bg-slate-50 border-slate-200">
                        <h4 class="mb-4 font-bold text-slate-700">Detalhes da Unidade</h4>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Quartos</label>
                                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', 0) }}" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Banheiros</label>
                                <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', 0) }}" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Status Atual *</label>
                                <select name="status" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach(\App\Enums\UnitStatus::cases() as $status)
                                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Layout: MÚLTIPLAS UNIDADES -->
                    <div x-show="isMultiUnit === 'yes'" x-collapse class="p-6 mb-8 border rounded-lg bg-slate-50 border-slate-200">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-slate-700">Cadastrar Unidades</h4>
                        </div>

                        <!-- Cabeçalho da Tabela (Oculto em telas muito pequenas) -->
                        <div class="hidden grid-cols-12 gap-4 px-2 mb-2 text-sm font-bold md:grid text-slate-500">
                            <div class="col-span-4">Identificação (Nome) *</div>
                            <div class="col-span-2">Quartos</div>
                            <div class="col-span-2">Banheiros</div>
                            <div class="col-span-3">Status *</div>
                            <div class="col-span-1 text-center">Ação</div>
                        </div>

                        <template x-for="(unit, index) in units" :key="unit.id">
                            <div class="grid items-center grid-cols-1 gap-4 p-4 mb-4 bg-white border rounded-lg md:grid-cols-12 md:p-2 border-slate-200 md:border-transparent md:bg-transparent">

                                <!-- Nome -->
                                <div class="md:col-span-4">
                                    <label class="block mb-1 text-xs font-bold md:hidden text-slate-500">Identificação *</label>
                                    <input type="text" :name="`units[${index}][name]`" x-model="unit.name" placeholder="Ex: Apt 101"
                                           class="block w-full rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                           :required="isMultiUnit === 'yes'">
                                </div>

                                <!-- Quartos -->
                                <div class="md:col-span-2">
                                    <label class="block mb-1 text-xs font-bold md:hidden text-slate-500">Quartos</label>
                                    <input type="number" :name="`units[${index}][bedrooms]`" x-model="unit.bedrooms" min="0" placeholder="0"
                                           class="block w-full rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <!-- Banheiros -->
                                <div class="md:col-span-2">
                                    <label class="block mb-1 text-xs font-bold md:hidden text-slate-500">Banheiros</label>
                                    <input type="number" :name="`units[${index}][bathrooms]`" x-model="unit.bathrooms" min="0" placeholder="0"
                                           class="block w-full rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <!-- Status -->
                                <div class="md:col-span-3">
                                    <label class="block mb-1 text-xs font-bold md:hidden text-slate-500">Status *</label>
                                    <select :name="`units[${index}][status]`" x-model="unit.status"
                                            class="block w-full rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                        @foreach(\App\Enums\UnitStatus::cases() as $status)
                                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Botão Remover -->
                                <div class="mt-2 text-right md:col-span-1 md:text-center md:mt-0">
                                    <button type="button" @click="units.splice(index, 1)" x-show="units.length > 1"
                                            class="flex items-center justify-center w-full gap-2 p-2 text-red-500 transition-colors rounded-md hover:text-red-700 bg-red-50 md:bg-transparent md:w-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="text-sm font-bold md:hidden">Remover</span>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Botão Adicionar Unidade -->
                        <button type="button" @click="units.push({ id: Date.now(), name: '', bedrooms: 0, bathrooms: 0, status: 'vacant' })"
                                class="flex items-center p-2 mt-2 text-sm font-bold transition-colors rounded text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Adicionar mais uma unidade
                        </button>
                    </div>

                    <!-- Botões Finais -->
                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('properties.index') }}" class="px-4 py-2 font-bold transition-colors border rounded-lg border-slate-300 text-slate-700 hover:bg-slate-50">Cancelar</a>
                        <button type="submit" class="px-6 py-2 font-bold text-white transition-colors rounded-lg shadow-sm bg-emerald-600 hover:bg-emerald-500">
                            Salvar Imóvel e Unidades
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

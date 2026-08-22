<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Adicionar Novo Inquilino (Qualificação Legal)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf

                    <h3 class="pb-2 mb-4 text-lg font-medium text-gray-900 border-b">Informações Pessoais</h3>

                    <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ex: João da Silva"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="joao@email.com"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                        <!-- CPF/CNPJ -->
                        <div>
                            <label for="document_number" class="block text-sm font-medium text-gray-700">CPF ou CNPJ *</label>
                            <input type="text" name="document_number" id="document_number" value="{{ old('document_number') }}" required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('document_number') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-medium text-gray-700">RG</label>
                            <input type="text" name="rg" id="rg" value="{{ old('rg') }}"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('rg') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone / WhatsApp *</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                        <!-- Nacionalidade -->
                        <div>
                            <label for="nationality" class="block text-sm font-medium text-gray-700">Nacionalidade</label>
                            <input type="text" name="nationality" id="nationality" value="{{ old('nationality', 'Brasileiro(a)') }}"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('nationality') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Profissão -->
                        <div>
                            <label for="profession" class="block text-sm font-medium text-gray-700">Profissão</label>
                            <input type="text" name="profession" id="profession" value="{{ old('profession') }}"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('profession') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Endereço Atual -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Endereço Residencial Atual *</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required placeholder="Rua, Número, Bairro, Cidade - Estado"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <h3 class="pb-2 mb-4 text-lg font-medium text-gray-900 border-b">Estado Civil e Cônjuge</h3>

                    <!-- Estado Civil -->
                    <div class="mb-4">
                        <label for="marital_status" class="block text-sm font-medium text-gray-700">Estado Civil</label>
                        <select name="marital_status" id="marital_status" onchange="toggleSpouseFields()"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione...</option>
                            @foreach(\App\Enums\MaritalStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('marital_status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('marital_status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dados do Cônjuge (Oculto por padrão) -->
                    <div id="spouse_fields" class="grid hidden grid-cols-1 gap-4 p-4 mb-4 border rounded-md md:grid-cols-2 bg-gray-50">
                        <div>
                            <label for="spouse_name" class="block text-sm font-medium text-gray-700">Nome do Cônjuge</label>
                            <input type="text" name="spouse_name" id="spouse_name" value="{{ old('spouse_name') }}"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('spouse_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="spouse_document" class="block text-sm font-medium text-gray-700">CPF do Cônjuge</label>
                            <input type="text" name="spouse_document" id="spouse_document" value="{{ old('spouse_document') }}"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('spouse_document') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('tenants.index') }}" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Salvar Inquilino</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script para mostrar/ocultar os dados do cônjuge -->
    <script>
        function toggleSpouseFields() {
            const status = document.getElementById('marital_status').value;
            const spouseFields = document.getElementById('spouse_fields');

            if (status === 'married' || status === 'stable_union') {
                spouseFields.classList.remove('hidden');
            } else {
                spouseFields.classList.add('hidden');
            }
        }

        // Executar ao carregar a página caso haja erro de validação e o select já esteja preenchido
        document.addEventListener("DOMContentLoaded", toggleSpouseFields);
    </script>
</x-app-layout>

<script>
        document.addEventListener('DOMContentLoaded', function () {

            // CPF and CNPJ Mask
            const applyDocumentMask = (value) => {
                value = value.replace(/\D/g, "");
                if (value.length > 14) value = value.substring(0, 14);

                if (value.length <= 11) {
                    // CPF Format
                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
                } else {
                    // CNPJ Format
                    value = value.replace(/^(\d{2})(\d)/, "$1.$2");
                    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                    value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
                    value = value.replace(/(\d{4})(\d)/, "$1-$2");
                }
                return value;
            };

            // Phone Mask (Supports 10 and 11 digits)
            const applyPhoneMask = (value) => {
                value = value.replace(/\D/g, "");
                if (value.length > 11) value = value.substring(0, 11);

                value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
                value = value.replace(/(\d)(\d{4})$/, "$1-$2");
                return value;
            };

            // Bind Document Masks
            const docInput = document.getElementById('document_number');
            const spouseDocInput = document.getElementById('spouse_document');

            if (docInput) {
                if(docInput.value) docInput.value = applyDocumentMask(docInput.value);
                docInput.addEventListener('input', (e) => e.target.value = applyDocumentMask(e.target.value));
            }
            if (spouseDocInput) {
                if(spouseDocInput.value) spouseDocInput.value = applyDocumentMask(spouseDocInput.value);
                spouseDocInput.addEventListener('input', (e) => e.target.value = applyDocumentMask(e.target.value));
            }

            // Bind Phone Mask
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                if(phoneInput.value) phoneInput.value = applyPhoneMask(phoneInput.value);
                phoneInput.addEventListener('input', (e) => e.target.value = applyPhoneMask(e.target.value));
            }
        });
    </script>

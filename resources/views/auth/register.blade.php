<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-blue-900">Crie sua conta</h2>
        <p class="mt-1 text-sm text-slate-500">Comece a gerenciar seus aluguéis de forma inteligente.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-blue-900">Nome Completo</label>
            <input id="name" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email & Phone -->
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
            <div>
                <label for="email" class="block text-sm font-medium text-blue-900">E-mail Profissional</label>
                <input id="email" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-blue-900">Telefone / WhatsApp</label>
                <input id="phone" oninput="maskPhone(event)" maxlength="15" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <!-- Documents -->
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
            <div>
                <label for="document_number" class="block text-sm font-medium text-blue-900">CPF ou CNPJ</label>
                <input id="document_number" oninput="maskDoc(event)" maxlength="18" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="document_number" :value="old('document_number')" required />
                <x-input-error :messages="$errors->get('document_number')" class="mt-2" />
            </div>
            <div>
                <label for="rg" class="block text-sm font-medium text-blue-900">RG</label>
                <input id="rg" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="rg" :value="old('rg')" required />
                <x-input-error :messages="$errors->get('rg')" class="mt-2" />
            </div>
        </div>

        <!-- Personal Details -->
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
            <div>
                <label for="nationality" class="block text-sm font-medium text-blue-900">Nacionalidade</label>
                <input id="nationality" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="nationality" :value="old('nationality')" placeholder="Ex: Brasileiro(a)" required />
                <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
            </div>
            <div>
                <label for="marital_status" class="block text-sm font-medium text-blue-900">Estado Civil</label>
                <select id="marital_status" name="marital_status" class="block w-full mt-1 bg-white rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                    <option value="">Selecione...</option>
                    <option value="single" @if(old('marital_status') == 'single') selected @endif>Solteiro(a)</option>
                    <option value="married" @if(old('marital_status') == 'married') selected @endif>Casado(a)</option>
                    <option value="divorced" @if(old('marital_status') == 'divorced') selected @endif>Divorciado(a)</option>
                    <option value="widowed" @if(old('marital_status') == 'widowed') selected @endif>Viúvo(a)</option>
                    <option value="stable_union" @if(old('marital_status') == 'stable_union') selected @endif>União Estável</option>
                </select>
                <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
            </div>
        </div>

        <!-- Address -->
        <div class="mt-4">
            <label for="address" class="block text-sm font-medium text-blue-900">Endereço Completo</label>
            <input id="address" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="text" name="address" :value="old('address')" placeholder="Rua, Número, Bairro, Cidade - UF" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Passwords -->
        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
            <div>
                <label for="password" class="block text-sm font-medium text-blue-900">Senha Segura</label>
                <input id="password" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-blue-900">Confirme a Senha</label>
                <input id="password_confirmation" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Register Button -->
        <div class="mt-6">
            <button type="submit" class="flex justify-center w-full px-4 py-3 text-sm font-bold text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-emerald-600 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Criar Minha Conta
            </button>
        </div>

        <div class="mt-6 text-sm text-center text-slate-600">
            Já possui uma conta?
            <a href="{{ route('login') }}" class="font-bold text-blue-900 transition-colors hover:text-blue-700">
                Faça login
            </a>
        </div>
    </form>
    <script>
        function maskPhone(e) {
            let v = e.target.value.replace(/\D/g, ""); // Remove all non-digits

            // Apply formatting: (XX) XXXXX-XXXX or (XX) XXXX-XXXX
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
            v = v.replace(/(\d)(\d{4})$/, "$1-$2");

            e.target.value = v;
        }

        function maskDoc(e) {
            let v = e.target.value.replace(/\D/g, ""); // Remove all non-digits

            if (v.length <= 11) {
                // CPF Mask: 000.000.000-00
                v = v.replace(/(\d{3})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            } else {
                // CNPJ Mask: 00.000.000/0000-00
                v = v.replace(/^(\d{2})(\d)/, "$1.$2");
                v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
                v = v.replace(/(\d{4})(\d)/, "$1-$2");
            }

            e.target.value = v;
        }
    </script>
</x-guest-layout>

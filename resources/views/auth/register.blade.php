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

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-blue-900">E-mail Profissional</label>
            <input id="email" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-blue-900">Senha Segura</label>
            <input id="password" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-blue-900">Confirme a Senha</label>
            <input id="password_confirmation" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
</x-guest-layout>

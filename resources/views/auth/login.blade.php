<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-blue-900">Bem-vindo de volta</h2>
        <p class="mt-1 text-sm text-slate-500">Acesse sua conta para gerenciar seus imóveis.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-blue-900">E-mail</label>
            <input id="email" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-blue-900">Senha</label>
            <input id="password" class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded shadow-sm border-slate-300 text-emerald-600 focus:ring-emerald-500" name="remember">
                <span class="ml-2 text-sm text-slate-600">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-emerald-600 hover:text-emerald-500" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <button type="submit" class="flex justify-center w-full px-4 py-3 text-sm font-bold text-white transition-colors duration-200 border border-transparent rounded-md shadow-sm bg-emerald-600 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Entrar na Plataforma
            </button>
        </div>

        <div class="mt-6 text-sm text-center text-slate-600">
            Ainda não tem uma conta?
            <a href="{{ route('register') }}" class="font-bold text-blue-900 transition-colors hover:text-blue-700">
                Cadastre-se grátis
            </a>
        </div>
    </form>
</x-guest-layout>

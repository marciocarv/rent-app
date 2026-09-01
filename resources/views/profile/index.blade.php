<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Meu Perfil & Assinatura
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

            <!-- Success Message -->
            @if (session('success'))
                <div class="p-4 text-emerald-900 bg-emerald-100 border-l-4 border-emerald-500 rounded-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Plan Information Card -->
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg border border-gray-100">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Seu Plano Atual</h2>
                    <p class="mt-1 text-sm text-gray-600">Detalhes da sua assinatura no Rent.app.</p>
                </header>

                <div class="mt-6 flex items-center justify-between p-6 bg-slate-50 border rounded-xl">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800 uppercase">{{ $user->plan_tier->value }}</h3>

                        @if($subscription && isset($subscription['status']))
                            <p class="mt-3 text-sm text-slate-600">
                                Status:
                                @if($subscription['status'] === 'authorized')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Ativo</span>
                                @elseif($subscription['status'] === 'paused')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pausado</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelado</span>
                                @endif
                            </p>

                            @if(isset($subscription['next_payment_date']))
                                <p class="mt-1 text-sm text-slate-600">
                                    Próxima cobrança: <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($subscription['next_payment_date'])->format('d/m/Y') }}</span>
                                </p>
                            @endif

                            <p class="mt-1 text-sm text-slate-600">
                                Valor: <span class="font-bold text-slate-900">R$ {{ number_format($subscription['auto_recurring']['transaction_amount'], 2, ',', '.') }}</span>
                                ({{ $subscription['auto_recurring']['frequency'] == 12 ? 'Anual' : 'Mensal' }})
                            </p>
                        @else
                            <p class="mt-2 text-sm text-slate-600">Você está no plano gratuito.</p>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('plans.index') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-500 shadow-sm transition">
                            Alterar Plano
                        </a>
                    </div>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg border border-gray-100">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Atualizar Senha</h2>
                    <p class="mt-1 text-sm text-gray-600">Garanta que sua conta esteja usando uma senha longa e aleatória para se manter segura.</p>
                </header>

                <form method="post" action="{{ route('profile.password') }}" class="mt-6 space-y-6 max-w-xl">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Senha Atual</label>
                        <input id="current_password" name="current_password" type="password" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('current_password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                        <input id="password" name="password" type="password" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 rounded-lg hover:bg-slate-700 shadow-sm transition">
                            Salvar Nova Senha
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

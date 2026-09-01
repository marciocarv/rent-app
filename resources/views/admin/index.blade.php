<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Painel de Administração (SaaS)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-4 border-l-4 rounded-md shadow-sm text-emerald-900 bg-emerald-100 border-emerald-500">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Metrics Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-5">
                <!-- NEW: Revenue Card -->
                <div class="p-6 text-white border shadow-sm bg-slate-800 border-slate-900 rounded-xl">
                    <p class="text-sm font-medium text-slate-300">Receita Mensal (MRR)</p>
                    <p class="mt-2 text-3xl font-bold">R$ {{ number_format($mrr, 2, ',', '.') }}</p>
                </div>

                <div class="p-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                    <p class="text-sm font-medium text-slate-500">Total Proprietários</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalLandlords }}</p>
                </div>

                <div class="p-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                    <p class="text-sm font-medium text-slate-500">Total Inquilinos</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalTenants }}</p>
                </div>

                <div class="p-6 bg-white border shadow-sm border-emerald-100 rounded-xl">
                    <p class="text-sm font-medium text-emerald-600">Premium</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-900">{{ $premiumUsers }}</p>
                </div>

                <div class="p-6 bg-white border border-blue-100 shadow-sm rounded-xl">
                    <p class="text-sm font-medium text-blue-600">Básico</p>
                    <p class="mt-2 text-3xl font-bold text-blue-900">{{ $basicUsers }}</p>
                </div>

                <div class="p-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                    <p class="text-sm font-medium text-slate-500">Grátis</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $freeUsers }}</p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="overflow-hidden bg-white border shadow-sm border-slate-100 sm:rounded-xl">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-lg font-medium text-slate-900">Gerenciamento de Usuários</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs uppercase border-b text-slate-700 bg-slate-50">
                            <tr>
                                <th class="px-6 py-3">Nome / E-mail</th>
                                <th class="px-6 py-3">Vencimento do Plano</th>
                                <th class="px-6 py-3">Ações (Mudar Plano)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- VERIFICAÇÃO DE INQUILINO ADICIONADA AQUI -->
                                        @if($user->role->value === 'tenant')
                                            <span class="font-bold text-slate-400">-</span>
                                        @else
                                            @if($user->plan_expires_at)
                                                <span class="{{ $user->plan_expires_at->isPast() ? 'text-red-600' : 'text-emerald-600' }} font-medium">
                                                    {{ $user->plan_expires_at->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-slate-400">Assinatura Contínua/Grátis</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- Inline form to change plans -->
                                        <form action="{{ route('admin.users.plan', $user->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="plan_tier" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500 py-1.5">
                                                <option value="free" {{ $user->plan_tier->value === 'free' ? 'selected' : '' }}>Grátis</option>
                                                <option value="basic" {{ $user->plan_tier->value === 'basic' ? 'selected' : '' }}>Básico</option>
                                                <option value="premium" {{ $user->plan_tier->value === 'premium' ? 'selected' : '' }}>Premium</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 rounded-md hover:bg-slate-700 transition">
                                                Salvar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

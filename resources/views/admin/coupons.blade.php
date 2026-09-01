<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            Gerenciar Cupons de Desconto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-4 border-l-4 rounded-md shadow-sm text-emerald-900 bg-emerald-100 border-emerald-500">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create Coupon Form -->
            <div class="p-6 bg-white border shadow sm:rounded-lg border-slate-100">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-slate-900">Novo Cupom</h2>
                </header>

                <form method="POST" action="{{ route('admin.coupons.store') }}" class="grid items-end grid-cols-1 gap-4 sm:grid-cols-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Código (ex: BETA50)</label>
                        <input type="text" name="code" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tipo de Desconto</label>
                        <select name="type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            <option value="percentage">Porcentagem (%)</option>
                            <option value="fixed">Valor Fixo (R$)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Valor</label>
                        <input type="number" step="0.01" name="value" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Limite de Uso (Opcional)</label>
                        <input type="number" name="usage_limit" placeholder="Ilimitado" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-4">
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 rounded-lg hover:bg-slate-700">
                            Gerar Cupom
                        </button>
                    </div>
                </form>
            </div>

            <!-- Coupons Table -->
            <div class="overflow-hidden bg-white border shadow-sm border-slate-100 sm:rounded-xl">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="text-lg font-medium text-slate-900">Cupons Ativos</h3>
                </div>

                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs uppercase border-b text-slate-700 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3">Código</th>
                            <th class="px-6 py-3">Desconto</th>
                            <th class="px-6 py-3">Usos</th>
                            <th class="px-6 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $coupon->code }}</td>
                                <td class="px-6 py-4">
                                    {{ $coupon->type === 'percentage' ? number_format($coupon->value, 0) . '%' : 'R$ ' . number_format($coupon->value, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-900">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

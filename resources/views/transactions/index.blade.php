<div x-data="{ isExpenseModalOpen: false }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-blue-900">
                {{ __('Painel Financeiro') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="flex items-center px-4 py-3 mb-6 border rounded-lg shadow-sm bg-emerald-50 border-emerald-200 text-emerald-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="px-4 py-3 mb-6 text-red-700 border border-red-200 rounded-lg bg-red-50">
                        <ul class="text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- NEW: Filter Bar -->
                <div class="p-4 mb-6 bg-white border shadow-sm border-slate-100 rounded-xl">
                    <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col items-center gap-4 sm:flex-row">
                        <div class="flex items-center w-full gap-2 sm:w-auto">
                            <label for="month" class="text-sm font-bold text-slate-700">Mês:</label>
                            <select name="month" id="month" class="block w-full rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @php
                                    $meses = [
                                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                                    ];
                                @endphp
                                @foreach($meses as $num => $nome)
                                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center w-full gap-2 sm:w-auto">
                            <label for="year" class="text-sm font-bold text-slate-700">Ano:</label>
                            <select name="year" id="year" class="block w-full rounded-md shadow-sm border-slate-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @foreach(range(date('Y') - 1, date('Y') + 3) as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 text-sm font-bold text-white transition-colors rounded-lg shadow-sm sm:w-auto bg-slate-800 hover:bg-slate-700">
                            Filtrar
                        </button>

                        @if(request()->has('month') || request()->has('year'))
                            <a href="{{ route('transactions.index') }}" class="w-full px-4 py-2 text-sm font-bold text-center transition-colors rounded-lg sm:w-auto text-slate-600 bg-slate-100 hover:bg-slate-200">
                                Limpar Filtro
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Metrics Grid -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                    <div class="p-6 bg-white border border-l-4 shadow-sm rounded-xl border-slate-100 border-l-amber-400">
                        <p class="mb-1 text-sm font-bold tracking-wider uppercase text-slate-500">Receitas Pendentes</p>
                        <h3 class="text-2xl font-extrabold text-blue-900">R$ {{ number_format($metrics['pending'], 2, ',', '.') }}</h3>
                    </div>
                    <div class="p-6 bg-white border border-l-4 shadow-sm rounded-xl border-slate-100 border-l-red-500">
                        <p class="mb-1 text-sm font-bold tracking-wider uppercase text-slate-500">Receitas em Atraso</p>
                        <h3 class="text-2xl font-extrabold text-red-600">R$ {{ number_format($metrics['overdue'], 2, ',', '.') }}</h3>
                    </div>
                    <div class="p-6 bg-white border border-l-4 shadow-sm rounded-xl border-slate-100 border-l-emerald-500">
                        <p class="mb-1 text-sm font-bold tracking-wider uppercase text-slate-500">Recebido (Este Mês)</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600">R$ {{ number_format($metrics['paid'], 2, ',', '.') }}</h3>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="overflow-hidden bg-white border shadow-sm sm:rounded-xl border-slate-100">
                    <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-blue-900">Faturas e Lançamentos</h3>
                        <button @click="isExpenseModalOpen = true" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500">
                            + Nova Despesa
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                                    <th class="p-4 font-bold">Descrição</th>
                                    <th class="p-4 font-bold">Inquilino / Unidade</th>
                                    <th class="p-4 font-bold">Vencimento</th>
                                    <th class="p-4 font-bold">Valor</th>
                                    <th class="p-4 font-bold">Status</th>
                                    <th class="p-4 font-bold text-right">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tbody class="divide-y divide-slate-100">
                                @php
                                    // Bulletproof month translation
                                    $mesesAbrev = [
                                        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
                                        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                                        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
                                    ];
                                @endphp

                                @forelse ($transactions as $transaction)
                                    @php
                                        $isOverdue = $transaction->status === 'pending' && $transaction->due_date < now()->startOfDay();

                                        // Check for tenant directly, or through the contract
                                        $tenantName = $transaction->tenant->name ?? $transaction->contract->tenant->name ?? null;
                                    @endphp
                                    <tr class="transition-colors hover:bg-slate-50">
                                        <td class="p-4">
                                            <p class="font-bold text-blue-900">{{ $transaction->description }}</p>
                                            <p class="text-xs font-bold {{ $transaction->type === 'revenue' ? 'text-emerald-500' : 'text-red-500' }}">
                                                {{ $transaction->type === 'revenue' ? '↑ Receita' : '↓ Despesa' }}
                                            </p>
                                        </td>

                                        <!-- UPDATED: Tenant & Property Name Logic -->
                                        <td class="p-4">
                                            @if($tenantName)
                                                <p class="text-sm font-bold text-slate-700">{{ $tenantName }}</p>
                                            @else
                                                <p class="text-sm font-bold text-slate-400 italic">Despesa Geral</p>
                                            @endif
                                            <p class="text-xs text-slate-500">{{ $transaction->unit->property->name ?? 'Imóvel Excluído' }} - {{ $transaction->unit->name ?? 'Geral' }}</p>
                                        </td>

                                        <!-- UPDATED: Foolproof Portuguese Date Logic -->
                                        <td class="p-4 text-sm font-medium text-slate-700">
                                            {{ $transaction->due_date->format('d') }} {{ $mesesAbrev[$transaction->due_date->format('n')] }} {{ $transaction->due_date->format('Y') }}
                                        </td>

                                        <td class="p-4 font-extrabold {{ $transaction->type === 'revenue' ? 'text-slate-700' : 'text-red-600' }}">
                                            R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </td>
                                        <td class="p-4">
                                            @if($transaction->status === 'paid')
                                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-full">Pago</span>
                                            @elseif($isOverdue)
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">Atrasado</span>
                                            @else
                                                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full">Pendente</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-right">
                                            @if($transaction->status === 'pending')
                                                <form action="{{ route('transactions.pay', $transaction) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-bold text-sm bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded transition-colors">
                                                        Dar Baixa
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-sm font-medium text-slate-400">Concluído</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-500">
                                            Nenhuma transação encontrada para este período.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </x-app-layout>

    <!-- Expense Modal Remains Identical -->
    <div x-show="isExpenseModalOpen" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <!-- ... Paste your exact modal code back here ... -->
        <div x-show="isExpenseModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-opacity-75 bg-slate-900"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

                <div x-show="isExpenseModalOpen"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     @click.outside="isExpenseModalOpen = false"
                     class="relative overflow-hidden text-left transition-all transform bg-white shadow-xl rounded-xl sm:my-8 sm:w-full sm:max-w-lg">

                    <form action="{{ route('transactions.storeExpense') }}" method="POST">
                        @csrf
                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                            <h3 class="mb-4 text-lg font-bold leading-6 text-blue-900" id="modal-title">Registrar Nova Despesa</h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-slate-700">Unidade (Onde ocorreu a despesa?) *</label>
                                    <select name="unit_id" id="unit_id" required class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                        <option value="" disabled selected>Selecione a unidade...</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->property->name }} - {{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-slate-700">Descrição *</label>
                                    <input type="text" name="description" id="description" required placeholder="Ex: Conserto da Tubulação, Pintura..." class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label for="amount" class="block text-sm font-medium text-slate-700">Valor (R$) *</label>
                                    <input type="text" name="amount" id="amount" required placeholder="0,00" class="block w-full mt-1 rounded-md shadow-sm mask-currency border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="due_date" class="block text-sm font-medium text-slate-700">Data de Vencimento *</label>
                                        <input type="date" name="due_date" id="due_date" required class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>

                                    <div>
                                        <label for="status" class="block text-sm font-medium text-slate-700">Status *</label>
                                        <select name="status" id="status" required class="block w-full mt-1 rounded-md shadow-sm border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                            <option value="paid" selected>Já está Pago</option>
                                            <option value="pending">Pendente (A Pagar)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-slate-50 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white transition-colors bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                Salvar Despesa
                            </button>
                            <button type="button" @click="isExpenseModalOpen = false" class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold transition-colors bg-white rounded-md shadow-sm text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const applyCurrencyMask = (value) => {
                value = value.replace(/\D/g, "");
                if (value === "") return "";
                value = (parseInt(value, 10) / 100).toFixed(2) + "";
                value = value.replace(".", ",");
                value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                return value;
            };

            document.querySelectorAll('.mask-currency').forEach(input => {
                input.addEventListener('input', (e) => {
                    e.target.value = applyCurrencyMask(e.target.value);
                });
            });
        });
    </script>
</div>

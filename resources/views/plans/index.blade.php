<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-blue-900">
            Planos e Assinaturas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="mb-12 text-center">
                <h1 class="text-3xl font-extrabold text-blue-900 sm:text-4xl">
                    Gerencie seus aluguéis sem limites
                </h1>
                @if (session('error'))
                    <div class="max-w-2xl px-4 py-3 mx-auto mb-8 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                        <span class="font-bold">Atenção:</span> {{ session('error') }}
                    </div>
                @endif
                <p class="max-w-2xl mx-auto mt-4 text-xl text-slate-500">
                    Escolha o plano perfeito para o tamanho do seu portfólio. Cancele quando quiser.
                </p>
            </div>

            <!-- Billing Cycle Toggle -->
            <div class="flex justify-center mt-8 mb-6">
                <div class="relative flex items-center p-1 bg-slate-200 rounded-xl">
                    <button type="button" id="btn-monthly" onclick="togglePlan('monthly')" class="relative w-32 py-2 text-sm font-medium transition-all bg-white rounded-lg shadow-sm text-slate-900">
                        Mensal
                    </button>
                    <button type="button" id="btn-annual" onclick="togglePlan('annual')" class="relative w-32 py-2 text-sm font-medium transition-all rounded-lg text-slate-500 hover:text-slate-900">
                        Anual <span class="ml-1 text-xs font-bold text-emerald-600">-20%</span>
                    </button>
                </div>
            </div>

            <!-- NOVO: Campo de Cupom de Desconto Global -->
            <div class="flex flex-col items-center justify-center mb-12">
                <div class="flex w-full max-w-sm gap-2">
                    <input type="text" id="coupon_input" placeholder="Possui um cupom?" class="w-full text-sm uppercase border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <button type="button" onclick="applyCoupon()" class="px-4 py-2 text-sm font-semibold text-white transition rounded-lg bg-slate-800 hover:bg-slate-700">
                        Aplicar
                    </button>
                </div>
                <!-- Mensagem de sucesso ou erro do cupom -->
                <div id="coupon_message" class="hidden mt-2 text-sm font-medium"></div>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid max-w-lg gap-8 mx-auto lg:grid-cols-3 lg:max-w-none">

                <!-- FREE PLAN -->
                <div class="flex flex-col overflow-hidden bg-white border shadow-sm rounded-2xl border-slate-200">
                    <div class="p-8">
                        <h3 class="text-xl font-semibold text-slate-900">Grátis</h3>
                        <p class="mt-4 text-sm text-slate-500">Para proprietários que estão começando.</p>
                        <div class="flex items-baseline mt-4 text-5xl font-extrabold text-blue-900">
                            R$0<span class="text-xl font-medium text-slate-500">/mês</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-400">Gratuito para sempre</p>
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-8 bg-slate-50">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">1 imóvel</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">2 unidades</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Gestão de chamados</p>
                            </li>
                            <li class="flex items-start opacity-50">
                                <svg class="w-6 h-6 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <p class="ml-3 text-base line-through text-slate-500">Assinatura digital de contratos</p>
                            </li>
                        </ul>
                        <div class="mt-8">
                            @if(auth()->user()->plan_tier->value === 'free')
                                <button disabled class="block w-full px-6 py-3 font-bold text-center rounded-lg text-slate-500 bg-slate-200">Seu plano atual</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- BASIC PLAN -->
                <div class="relative flex flex-col overflow-hidden bg-white border-2 shadow-lg rounded-2xl border-emerald-500">
                    <div class="absolute top-0 right-0 px-3 py-1 text-xs font-semibold tracking-wide text-white uppercase rounded-bl-lg bg-emerald-500">Custo Benefício</div>
                    <div class="p-8">
                        <h3 class="text-xl font-semibold text-slate-900">Básico</h3>
                        <p class="mt-4 text-sm text-slate-500">Ideal para quem tem alguns imóveis.</p>
                        <div class="flex items-baseline mt-4 text-5xl font-extrabold text-blue-900" id="price-basic">
                            R$9,99<span class="text-xl font-medium text-slate-500">/mês</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-400" id="desc-basic">Cobrado mensalmente</p>
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-8 bg-slate-50">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Até 3 imóveis</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Até 6 unidades</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Gestão de chamados</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base font-bold text-slate-700">Assinatura digital ilimitada</p>
                            </li>
                        </ul>
                        <div class="mt-8">
                            @if(auth()->user()->plan_tier->value === 'basic')
                                <button disabled class="block w-full px-6 py-3 font-bold text-center rounded-lg text-slate-500 bg-slate-200">Seu plano atual</button>
                            @else
                                <form id="form-basic" action="{{ route('plans.checkout', ['plan' => 'basic', 'cycle' => 'monthly']) }}" method="POST">
                                    @csrf
                                    <!-- NOVO: Input hidden para enviar o cupom ao controller -->
                                    <input type="hidden" name="coupon_code" class="applied_coupon_input">
                                    <button type="submit" class="block w-full px-6 py-3 font-bold text-center text-white transition-colors rounded-lg shadow-sm bg-emerald-600 hover:bg-emerald-500">Assinar Básico</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- PREMIUM PLAN -->
                <div class="flex flex-col overflow-hidden bg-white border shadow-sm rounded-2xl border-slate-200">
                    <div class="p-8">
                        <h3 class="text-xl font-semibold text-slate-900">Premium</h3>
                        <p class="mt-4 text-sm text-slate-500">Para investidores profissionais.</p>
                        <div class="flex items-baseline mt-4 text-5xl font-extrabold text-blue-900" id="price-premium">
                            R$19,99<span class="text-xl font-medium text-slate-500">/mês</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-400" id="desc-premium">Cobrado mensalmente</p>
                    </div>
                    <div class="flex flex-col justify-between flex-1 p-8 bg-slate-50">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Imóveis <span class="font-bold">Ilimitados</span></p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Unidades <span class="font-bold">Ilimitadas</span></p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base text-slate-700">Gestão de chamados</p>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="ml-3 text-base font-bold text-slate-700">Assinatura digital ilimitada</p>
                            </li>
                        </ul>
                        <div class="mt-8">
                            @if(auth()->user()->plan_tier->value === 'premium')
                                <button disabled class="block w-full px-6 py-3 font-bold text-center rounded-lg text-slate-500 bg-slate-200">Seu plano atual</button>
                            @else
                                <form id="form-premium" action="{{ route('plans.checkout', ['plan' => 'premium', 'cycle' => 'monthly']) }}" method="POST">
                                    @csrf
                                    <!-- NOVO: Input hidden para enviar o cupom ao controller -->
                                    <input type="hidden" name="coupon_code" class="applied_coupon_input">
                                    <button type="submit" class="block w-full px-6 py-3 font-bold text-center text-blue-900 transition-colors bg-blue-100 rounded-lg shadow-sm hover:bg-blue-200">Assinar Premium</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script to Handle Billing Toggle & Dynamic Coupon Logic -->
    <script>
        // Routes definitions
        const routeBasicMonthly = "{{ route('plans.checkout', ['plan' => 'basic', 'cycle' => 'monthly']) }}";
        const routeBasicAnnual = "{{ route('plans.checkout', ['plan' => 'basic', 'cycle' => 'annual']) }}";
        const routePremiumMonthly = "{{ route('plans.checkout', ['plan' => 'premium', 'cycle' => 'monthly']) }}";
        const routePremiumAnnual = "{{ route('plans.checkout', ['plan' => 'premium', 'cycle' => 'annual']) }}";

        // State variables
        let currentCycle = 'monthly';
        let appliedCoupon = null; // Will store { type: 'percentage', value: 20 }

        // Base price dictionary
        const basePrices = {
            basic: { monthly: 9.99, annual_mo: 5.99, annual_total: 71.88 },
            premium: { monthly: 19.99, annual_mo: 14.99, annual_total: 179.88 }
        };

        // Formatting helper
        function formatCurrency(value) {
            return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Apply discount math
        function calculateDiscount(baseAmount) {
            if (!appliedCoupon) return baseAmount;

            if (appliedCoupon.type === 'percentage') {
                return Math.max(0, baseAmount - (baseAmount * (appliedCoupon.value / 100)));
            }
            return Math.max(0, baseAmount - appliedCoupon.value);
        }

        // Main rendering function
        function togglePlan(cycle = currentCycle) {
            currentCycle = cycle;
            const isAnnual = cycle === 'annual';

            const btnActiveClasses = 'relative w-32 py-2 text-sm font-medium text-slate-900 transition-all bg-white rounded-lg shadow-sm';
            const btnInactiveClasses = 'relative w-32 py-2 text-sm font-medium transition-all rounded-lg text-slate-500 hover:text-slate-900';

            document.getElementById('btn-monthly').className = isAnnual ? btnInactiveClasses : btnActiveClasses;
            document.getElementById('btn-annual').className = isAnnual ? btnActiveClasses : btnInactiveClasses;

            // --- Basic Plan Math ---
            let basicMo = isAnnual ? basePrices.basic.annual_mo : basePrices.basic.monthly;
            let basicTotal = isAnnual ? basePrices.basic.annual_total : basePrices.basic.monthly;

            basicMo = calculateDiscount(basicMo);
            basicTotal = calculateDiscount(basicTotal);

            document.getElementById('price-basic').innerHTML = `R$${formatCurrency(basicMo)}<span class="text-xl font-medium text-slate-500">/mês</span>`;
            document.getElementById('desc-basic').innerText = isAnnual ? `Cobrado R$ ${formatCurrency(basicTotal)} anualmente` : 'Cobrado mensalmente';
            if(document.getElementById('form-basic')) {
                document.getElementById('form-basic').action = isAnnual ? routeBasicAnnual : routeBasicMonthly;
            }

            // --- Premium Plan Math ---
            let premiumMo = isAnnual ? basePrices.premium.annual_mo : basePrices.premium.monthly;
            let premiumTotal = isAnnual ? basePrices.premium.annual_total : basePrices.premium.monthly;

            premiumMo = calculateDiscount(premiumMo);
            premiumTotal = calculateDiscount(premiumTotal);

            document.getElementById('price-premium').innerHTML = `R$${formatCurrency(premiumMo)}<span class="text-xl font-medium text-slate-500">/mês</span>`;
            document.getElementById('desc-premium').innerText = isAnnual ? `Cobrado R$ ${formatCurrency(premiumTotal)} anualmente` : 'Cobrado mensalmente';
            if(document.getElementById('form-premium')) {
                document.getElementById('form-premium').action = isAnnual ? routePremiumAnnual : routePremiumMonthly;
            }
        }

        // AJAX function to validate coupon with backend
        async function applyCoupon() {
            const code = document.getElementById('coupon_input').value.toUpperCase();
            const msgEl = document.getElementById('coupon_message');

            if (!code) return;

            try {
                // Call the backend route we are about to create
                const response = await fetch(`/api/cupons/check?code=${code}`);
                const data = await response.json();

                if (data.valid) {
                    // Store the discount config
                    appliedCoupon = { code: code, type: data.type, value: parseFloat(data.value) };

                    // Inject the validated code into the form hidden inputs so it passes to the controller
                    document.querySelectorAll('.applied_coupon_input').forEach(el => el.value = code);

                    // Show success message
                    msgEl.innerHTML = `<span class="text-emerald-600">Cupom ${code} aplicado com sucesso!</span>`;
                    msgEl.classList.remove('hidden');

                    // Rerender prices
                    togglePlan();
                } else {
                    // Reset everything if invalid
                    appliedCoupon = null;
                    document.querySelectorAll('.applied_coupon_input').forEach(el => el.value = '');

                    // Show error message
                    msgEl.innerHTML = `<span class="text-red-600">${data.message || 'Cupom inválido.'}</span>`;
                    msgEl.classList.remove('hidden');

                    // Rerender prices
                    togglePlan();
                }
            } catch (error) {
                console.error("Erro ao validar cupom:", error);
            }
        }
    </script>
</x-app-layout>

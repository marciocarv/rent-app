<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rent.app - Gestão Inteligente de Aluguéis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Base styles for scroll animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-emerald-400 selection:text-blue-950">

    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full border-b border-blue-900 shadow-sm bg-blue-950/95 backdrop-blur-md">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 transition-transform group hover:scale-105">
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-800 shadow-sm rounded-br-xl rounded-tl-xl">
                        <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">Rent<span class="text-emerald-400">.app</span></span>
                </a>

                <div class="hidden md:block">
                    <div class="flex items-baseline ml-10 space-x-8">
                        <a href="#dores" class="text-sm font-medium text-blue-200 transition hover:text-emerald-400">O Problema</a>
                        <a href="#funcionalidades" class="text-sm font-medium text-blue-200 transition hover:text-emerald-400">Solução</a>
                        <a href="#precos" class="text-sm font-medium text-blue-200 transition hover:text-emerald-400">Planos</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold transition-colors text-emerald-400 hover:text-emerald-300">Acessar Painel &rarr;</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-blue-200 transition-colors hover:text-white">Entrar</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-blue-950 transition-all rounded-lg bg-emerald-400 hover:bg-emerald-300 hover:shadow-lg hover:shadow-emerald-400/20 hover:-translate-y-0.5">Criar Conta</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Dark Theme) -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-blue-950 sm:pt-40 sm:pb-24">
        <!-- Abstract Background Glow -->
        <div class="absolute top-0 transform -translate-x-1/2 left-1/2 w-[800px] h-[400px] bg-emerald-500/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="relative px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8 reveal active">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-6 text-sm font-medium rounded-full text-emerald-400 bg-emerald-400/10 border border-emerald-400/20">
                <span class="relative flex w-2 h-2">
                  <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-emerald-400"></span>
                  <span class="relative inline-flex w-2 h-2 rounded-full bg-emerald-500"></span>
                </span>
                O futuro da gestão imobiliária chegou
            </div>
            <h1 class="max-w-4xl mx-auto text-5xl font-extrabold tracking-tight text-white sm:text-6xl md:text-7xl">
                Alugue seus imóveis sem a <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-emerald-200">dor de cabeça.</span>
            </h1>
            <p class="max-w-2xl mx-auto mt-6 text-lg text-blue-200 sm:text-xl">
                Automatize cobranças, assine contratos digitalmente e centralize a comunicação com seus inquilinos. A plataforma definitiva para proprietários modernos.
            </p>
            <div class="flex flex-col justify-center gap-4 mt-10 sm:flex-row">
                <a href="{{ route('register') }}" class="px-8 py-3.5 text-base font-bold text-blue-950 bg-emerald-400 rounded-xl hover:bg-emerald-300 shadow-lg shadow-emerald-400/20 transition-all hover:-translate-y-1">
                    Começar Gratuitamente
                </a>
                <a href="#dores" class="px-8 py-3.5 text-base font-medium text-white transition-all bg-transparent border border-blue-800 rounded-xl hover:bg-blue-900 hover:-translate-y-1">
                    Entender como funciona
                </a>
            </div>
        </div>
    </section>

    <!-- The Pain Section -->
    <section id="dores" class="py-24 bg-slate-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto mb-16 text-center reveal">
                <h2 class="text-sm font-bold tracking-wider uppercase text-rose-500">A Realidade Atual</h2>
                <h3 class="mt-2 text-3xl font-bold text-blue-950 sm:text-4xl">Gerenciar imóveis não deveria ser um segundo emprego</h3>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="p-8 delay-100 bg-white border shadow-sm border-slate-200 rounded-2xl reveal">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 bg-rose-50 text-rose-500 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="mb-3 text-xl font-bold text-blue-950">Cobranças Desgastantes</h4>
                    <p class="leading-relaxed text-slate-600">Ter que enviar mensagens de WhatsApp todo mês lembrando do aluguel gera desgaste e atrasos constantes.</p>
                </div>

                <div class="p-8 delay-200 bg-white border shadow-sm border-slate-200 rounded-2xl reveal">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 bg-rose-50 text-rose-500 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="mb-3 text-xl font-bold text-blue-950">Burocracia com Contratos</h4>
                    <p class="leading-relaxed text-slate-600">Imprimir, reconhecer firma e guardar papéis que acabam se perdendo ou rasgando com o tempo.</p>
                </div>

                <div class="p-8 delay-300 bg-white border shadow-sm border-slate-200 rounded-2xl reveal">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 bg-rose-50 text-rose-500 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="mb-3 text-xl font-bold text-blue-950">Manutenções Caóticas</h4>
                    <p class="leading-relaxed text-slate-600">Inquilinos reclamando de problemas por áudio e fotos soltas na galeria do seu celular sem nenhum controle de gastos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- The Solution (Features) -->
    <section id="funcionalidades" class="py-24 overflow-hidden bg-white border-y border-slate-200">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto mb-20 text-center reveal">
                <h2 class="text-sm font-bold tracking-wider uppercase text-emerald-500">A Solução Rent.app</h2>
                <h3 class="mt-2 text-3xl font-bold text-blue-950 sm:text-4xl">Tudo organizado. Tudo automático.</h3>
                <p class="mt-4 text-lg text-slate-600">Nossa plataforma unifica a gestão financeira, operacional e jurídica dos seus imóveis.</p>
            </div>

            <!-- Feature 1: Financeiro -->
            <div class="flex flex-col items-center gap-12 mb-24 lg:flex-row reveal">
                <div class="flex-1 lg:pr-12">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 bg-emerald-100 text-emerald-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="mb-4 text-3xl font-bold text-blue-950">Motor Financeiro Inteligente</h4>
                    <p class="mb-6 text-lg text-slate-600">Faturas mensais de aluguel criadas automaticamente[cite: 1]. Tenha total controle sobre pagamentos pendentes, multas por atraso e o lucro real do seu portfólio.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-700"><svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Emissão automática de cobranças</li>
                        <li class="flex items-center text-slate-700"><svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Controle de despesas por imóvel</li>
                    </ul>
                </div>
                <div class="flex-1 w-full p-8 transition-colors border shadow-inner bg-slate-100 rounded-3xl border-slate-200 group hover:bg-slate-50">
                    <!-- Fake UI Mockup -->
                    <div class="p-6 transition-transform duration-500 transform bg-white border shadow-sm rounded-xl border-slate-200 group-hover:scale-105">
                        <div class="flex items-center justify-between mb-6">
                            <h5 class="font-bold text-blue-950">Receita do Mês</h5>
                            <span class="px-2 py-1 text-sm font-semibold rounded text-emerald-500 bg-emerald-50">+12%</span>
                        </div>
                        <div class="mb-8 text-4xl font-extrabold text-blue-950">R$ 14.500,00</div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                                <span class="text-sm font-medium text-slate-600">Apto 101 - João</span>
                                <span class="text-sm font-bold text-emerald-500">Pago</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-rose-50">
                                <span class="text-sm font-medium text-slate-600">Casa Centro - Maria</span>
                                <span class="text-sm font-bold text-rose-500">Atrasado</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Contratos -->
            <div class="flex flex-col items-center gap-12 mb-24 lg:flex-row-reverse reveal">
                <div class="flex-1 lg:pl-12">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 text-blue-600 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="mb-4 text-3xl font-bold text-blue-950">Contratos e Assinaturas</h4>
                    <p class="mb-6 text-lg text-slate-600">Gere contratos automaticamente baseados em templates validados[cite: 1]. Colete assinaturas digitais de forma segura, com registro de IP e validade legal[cite: 1].</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-700"><svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Assinatura 100% digital[cite: 1]</li>
                        <li class="flex items-center text-slate-700"><svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Armazenamento seguro na nuvem</li>
                    </ul>
                </div>
                <div class="flex-1 w-full p-8 transition-colors border shadow-inner bg-slate-100 rounded-3xl border-slate-200 group hover:bg-slate-50">
                     <!-- Fake UI Mockup -->
                     <div class="p-6 transition-transform duration-500 transform bg-white border shadow-sm rounded-xl border-slate-200 group-hover:scale-105">
                        <div class="w-full h-8 mb-4 rounded bg-slate-100"></div>
                        <div class="w-3/4 h-4 mb-8 rounded bg-slate-100"></div>
                        <div class="p-6 text-center border-2 border-dashed rounded-lg border-emerald-200 bg-emerald-50">
                            <svg class="w-8 h-8 mx-auto mb-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold text-emerald-700">Assinado por João da Silva</span>
                            <div class="mt-1 text-xs text-emerald-600">IP: 192.168.1.1 - Hoje às 14:30</div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Feature 3: Inquilinos -->
             <div class="flex flex-col items-center gap-12 lg:flex-row reveal">
                <div class="flex-1 lg:pr-12">
                    <div class="flex items-center justify-center w-12 h-12 mb-6 text-indigo-600 bg-indigo-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="mb-4 text-3xl font-bold text-blue-950">Gestão de Inquilinos e Manutenções</h4>
                    <p class="mb-6 text-lg text-slate-600">Cadastre inquilinos com facilidade[cite: 1]. O sistema conta com um portal exclusivo onde o inquilino abre chamados de manutenção documentados (Ticket), e você acompanha o status de cada um[cite: 1].</p>
                </div>
                <div class="flex-1 w-full p-8 transition-colors border shadow-inner bg-slate-100 rounded-3xl border-slate-200 group hover:bg-slate-50">
                     <div class="p-6 transition-transform duration-500 transform bg-white border shadow-sm rounded-xl border-slate-200 group-hover:scale-105">
                        <h5 class="mb-4 font-bold text-blue-950">Tickets de Manutenção</h5>
                        <div class="space-y-3">
                            <div class="p-4 border-l-4 rounded-r-lg border-amber-500 bg-amber-50">
                                <div class="flex justify-between">
                                    <span class="font-bold text-amber-900">Torneira vazando</span>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-amber-700 bg-amber-200">Em Aberto</span>
                                </div>
                                <p class="mt-2 text-sm text-amber-800">Apto 202 - Aberto ontem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Pricing Section -->
    <section id="precos" class="py-24 bg-blue-950">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto mb-16 text-center reveal">
                <h2 class="text-3xl font-bold text-white sm:text-4xl">Planos que crescem com você</h2>
                <p class="mt-4 text-lg text-blue-200">Simples, transparente e sem taxas escondidas.</p>
            </div>

            <div class="grid max-w-5xl grid-cols-1 gap-8 mx-auto md:grid-cols-3">
                <!-- Free Plan -->
                <div class="flex flex-col p-8 transition-transform delay-100 bg-blue-900 border border-blue-800 rounded-3xl reveal hover:-translate-y-2">
                    <h3 class="text-lg font-semibold text-white">Iniciante</h3>
                    <p class="flex items-baseline mt-4 text-4xl font-extrabold text-white">R$ 0<span class="ml-1 text-base font-medium text-blue-300">/mês</span></p>
                    <p class="mt-4 text-sm text-blue-300">Ideal para testar a plataforma.</p>
                    <ul class="flex-1 mt-8 space-y-4">
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm text-blue-100">1 Imóvel / Unidade</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm text-blue-100">Geração de contratos básicos</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 mt-8 text-sm font-bold text-center text-white transition border-2 border-blue-700 rounded-xl hover:bg-blue-800">Começar Grátis</a>
                </div>

                <!-- Basic Plan (Highlighted) -->
                <div class="relative z-10 flex flex-col p-8 delay-200 scale-105 bg-white border-2 shadow-2xl rounded-3xl shadow-emerald-900/50 reveal border-emerald-400">
                    <div class="absolute top-0 transform -translate-x-1/2 -translate-y-1/2 left-1/2">
                        <span class="bg-emerald-400 text-blue-950 text-xs font-extrabold uppercase tracking-widest py-1.5 px-4 rounded-full shadow-sm">Mais Escolhido</span>
                    </div>
                    <h3 class="text-lg font-bold text-blue-950">Profissional</h3>
                    <p class="flex items-baseline mt-4 text-4xl font-extrabold text-blue-950">R$ 29,90<span class="ml-1 text-base font-medium text-slate-500">/mês</span></p>
                    <p class="mt-4 text-sm text-slate-600">Para investidores ativos.</p>
                    <ul class="flex-1 mt-8 space-y-4">
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm font-medium text-slate-700">Até 10 Imóveis</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm font-medium text-slate-700">Assinaturas digitais com validade legal</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm font-medium text-slate-700">Automação de faturas e cobranças</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm font-medium text-slate-700">Portal do Inquilino</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 mt-8 text-sm font-bold text-center transition shadow-lg text-blue-950 bg-emerald-400 rounded-xl hover:bg-emerald-300 shadow-emerald-400/30 hover:-translate-y-1">Assinar Profissional</a>
                </div>

                <!-- Premium Plan -->
                <div class="flex flex-col p-8 transition-transform delay-300 bg-blue-900 border border-blue-800 rounded-3xl reveal hover:-translate-y-2">
                    <h3 class="text-lg font-semibold text-white">Escala</h3>
                    <p class="flex items-baseline mt-4 text-4xl font-extrabold text-white">R$ 79,90<span class="ml-1 text-base font-medium text-blue-300">/mês</span></p>
                    <p class="mt-4 text-sm text-blue-300">Para administradoras de bens.</p>
                    <ul class="flex-1 mt-8 space-y-4">
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm text-blue-100">Imóveis Ilimitados</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm text-blue-100">Todos os recursos do Profissional</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-sm text-blue-100">Suporte prioritário via WhatsApp</span></li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 mt-8 text-sm font-bold text-center text-white transition border-2 border-blue-700 rounded-xl hover:bg-blue-800">Falar com Consultor</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-blue-900 bg-blue-950">
        <div class="flex flex-col items-center px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 mb-6">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-800 rounded-tl-lg rounded-br-lg">
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-white">Rent<span class="text-emerald-400">.app</span></span>
            </a>

            <p class="text-sm text-blue-400">© {{ date('Y') }} Rent.app. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Script for Scroll Reveal Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>

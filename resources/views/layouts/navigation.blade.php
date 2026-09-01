<!-- Mobile Backdrop -->
<div x-show="sidebarOpen" style="display: none;" class="fixed inset-0 z-40 bg-slate-900/80 lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

<!-- Sidebar Container -->
<nav :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-50 w-64 text-white transition-transform duration-300 bg-blue-900 shadow-xl lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:w-64 lg:flex-col">

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-4 border-b border-blue-800 bg-blue-950">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 transition-transform group hover:scale-105">
            <div class="flex items-center justify-center w-8 h-8 bg-blue-800 shadow-sm rounded-br-xl rounded-tl-xl">
                <div class="w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse"></div>
            </div>
            <span class="text-2xl font-extrabold tracking-tight text-white">Rent<span class="text-emerald-400">.app</span></span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
        @if(auth()->user()->isLandlord())
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        <!-- Imóveis (Properties) -->
        <a href="{{ route('properties.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('properties.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('properties.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span class="text-sm font-medium">Imóveis</span>
        </a>

        <!-- Inquilinos (Tenants) -->
        <a href="{{ route('tenants.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('tenants.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('tenants.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span class="text-sm font-medium">Inquilinos</span>
        </a>

        <!-- Contratos (Contracts) -->
        <a href="{{ route('contracts.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('contracts.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('contracts.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="text-sm font-medium">Contratos</span>
        </a>

        <!-- Financeiro -->
        <a href="{{ route('transactions.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('transactions.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('transactions.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium">Financeiro</span>
        </a>

        <a href="{{ route('tickets.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('tickets.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('tickets.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-sm font-medium">Manutenção</span>
        </a>
        <a href="{{ route('plans.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('plans.index') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('tickets.*') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-sm font-medium">Planos</span>
        </a>

        @endif
        @if(auth()->user()->isTenant())
        <a href="{{ route('tenants.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('tenant.dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('tenant.dashboard') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-sm font-medium">Meu Imóvel</span>
        </a>
        @endif
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('tenant.dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('tenant.dashboard') ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-sm font-medium">Cupon de desconto</span>
        </a>
        @endif

    </div>

    <!-- User Profile & Logout (Pinned to bottom) -->
    <div class="p-4 border-t border-blue-800 bg-blue-950">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-10 h-10 text-lg font-bold border rounded-full bg-emerald-100 border-emerald-500 text-emerald-700">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-medium text-white truncate"><a href="{{ route('profile.index')}}"> {{ Auth::user()->name   }}</a></p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-blue-300 hover:text-emerald-400 mt-0.5 transition-colors font-medium">Sair da conta</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rent.app') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-slate-50">

            <!-- Custom CSS Logo -->
            <div>
                <a href="/" class="flex items-center gap-2 transition-transform group hover:scale-105">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-900 shadow-lg rounded-br-2xl rounded-tl-2xl">
                        <div class="w-4 h-4 rounded-full bg-emerald-400 animate-pulse"></div>
                    </div>
                    <span class="text-4xl font-extrabold tracking-tight text-blue-900">Rent<span class="text-emerald-500">.app</span></span>
                </a>
            </div>

            <!-- Form Container -->
            <div class="w-full px-8 py-10 mt-8 overflow-hidden bg-white border shadow-2xl sm:max-w-md border-slate-100 sm:rounded-xl">
                {{ $slot }}
            </div>

            <!-- Footer text for trust -->
            <div class="mt-8 text-sm text-slate-400">
                &copy; {{ date('Y') }} Rent.app — Gestão Imobiliária Segura
            </div>
        </div>
    </body>
</html>

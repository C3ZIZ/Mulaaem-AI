<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mulaaem') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans">
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="font-bold text-2xl text-blue-600 tracking-tight">Mulaaem</a>
                </div>
                <div class="flex items-center">
                    <a href="/admin" class="text-sm font-medium text-gray-500 hover:text-blue-600">Recruiter Login &rarr;</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-200 py-8 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} Mulaaem AI. Aziz?.
    </footer>
</body>
</html>
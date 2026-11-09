<!DOCTYPE html>
<html lang="id" class="{{ ($darkMode ?? false) ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Profil Akademik Mahasiswa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-white">
    <nav class="bg-blue-700 text-white shadow">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg">Profil Akademik</h1>
            <div class="flex gap-5 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <a href="{{ route('profil') }}" class="hover:underline">Profil Mahasiswa</a>
                <a href="{{ route('ide-agent') }}" class="hover:underline">Ide Agentic AI</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login Admin</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="max-w-6xl mx-auto px-6 py-10">
        @yield('content')
    </main>
    <footer class="bg-slate-800 text-white text-center py-6">
        <p class="font-semibold">Profil Akademik Mahasiswa</p>
        <p class="text-sm text-slate-400 mt-1">Laravel + Blade + Tailwind CSS + Vite</p>
    </footer>
</body>
</html>

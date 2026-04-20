<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin peminjam</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body style="background-color: #FFF7E6;">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 text-gray-800 flex flex-col shadow-lg border-r border-gray-200" style="background-color: #FFF7E6;">

        <!-- USER -->
        <div class="p-4 text-sm border-b border-gray-200" style="background-color: #9772b0;">
            <span style="color: #374151;">Login sebagai:</span><br>
            <b style="color: #374151;">{{ auth()->user()->name }}</b><br>
        </div>

        <!-- MENU -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

            <!-- DASHBOARD -->
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('dashboard') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                🏠 Dashboard
            </a>

            <!-- MASTER DATA -->
            <div class="mt-4 pt-2">
                <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Master Data</p>
            </div>

            <a href="{{ route('tools.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('tools*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #2e004f; border-color: transparent;' }}">
                📦 Data Alat
            </a>

            <a href="{{ route('categories.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('categories*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                🏷️ Kategori
            </a>

            <!-- TRANSAKSI -->
            <div class="mt-4 pt-2">
                <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Transaksi</p>
            </div>

            <a href="{{ route('loans.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('loans*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                🔄 Data Peminjamaan
            </a>

            <a href="{{ route('returns.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('returns*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                ↩️ Pengembalian
            </a>

            <!-- ADMINISTRATOR -->
            <div class="mt-4 pt-2">
                <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Administrator</p>
            </div>

            <a href="{{ route('users.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('users*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                👥 Manajemen User
            </a>

            <a href="{{ route('activity-logs.index') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('activity-logs*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                📊 Log Aktivitas
            </a>

        </nav>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-200">
            @csrf
            <button class="w-full py-2 rounded font-semibold transition" style="background-color: #9772b0; color: #FFFFFF;">
                🚪 Logout
            </button>
        </form>

    </div>

    <!-- KONTEN -->
    <div class="flex-1 p-8 text-gray-900 overflow-x-auto" style="background-color: #FFF7E6;">
        @yield('content')
    </div>

</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas - Alat</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body style="background-color: #FFF7E6;">

<div class="flex min-h-screen">

    <!-- SIDEBAR PETUGAS -->
    <div class="w-64 text-gray-800 flex flex-col shadow-lg border-r border-gray-200 sidebar-petugas" style="background-color: #FFF7E6;">

        <!-- LOGO -->
        <div class="p-4 text-xl font-bold border-b border-gray-200 rounded-b-lg" style="background-color: #ff4949; color: #374151;">
            📚Petugas
        </div>

        <!-- USER -->
        <div class="p-4 text-sm border-b border-gray-200" style="background-color: #ffb8b8;">
            <span style="color: #374151;">Login sebagai:</span><br>
            <b style="color: #374151;">{{ auth()->user()->name }}</b><br>
        </div>

        <!-- MENU -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

            <!-- DASHBOARD -->
            <a href="{{ route('petugas.dashboard') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/dashboard') ? 'background-color: #CDEDEA; color: #374151; border-color: #ff5b5b;' : 'color: #652929; border-color: transparent;' }}">
                🏠 Dashboard
            </a>

            <!-- TRANSAKSI -->
            <div class="mt-4 pt-2">
                <p class="text-xs font-bold uppercase" style="color: #513737; opacity: 0.6;">Transaksi</p>
            </div>

            <a href="{{ route('petugas.tools') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/tools*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                📦 Daftar Alat
            </a>

            <a href="{{ route('petugas.approve-loans') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/approve-loans*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                ✅ Setujui Peminjaman
            </a>

            <a href="{{ route('petugas.validate-returns') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/validate-returns*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                ✔️ Validasi Pengembalian
            </a>

            <!-- LAPORAN -->
            <div class="mt-4 pt-2">
                <p class="text-xs font-bold uppercase" style="color: #374151; opacity: 0.6;">Laporan</p>
            </div>

            <a href="{{ route('petugas.reports') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/reports*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                📊 Laporan
            </a>

            <a href="{{ route('petugas.laporan-peminjaman') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/laporan-peminjaman*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                📚 Laporan Peminjaman
            </a>

            <a href="{{ route('petugas.verify-denda-payments') }}"
               class="block px-4 py-2 rounded transition font-semibold border-l-4"
               style="{{ request()->is('petugas/verify-denda-payments*') ? 'background-color: #CDEDEA; color: #374151; border-color: #5B9FFF;' : 'color: #374151; border-color: transparent;' }}">
                💰 Verifikasi Denda
            </a>
        </nav>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-200">
            @csrf
            <button class="w-full py-2 rounded font-semibold transition" style="background-color: #5B9FFF; color: #FFFFFF;">
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

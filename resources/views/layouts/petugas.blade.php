<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas - Alat</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-red-50"> <div class="flex min-h-screen">

    <aside class="w-64 bg-white text-gray-800 flex flex-col shadow-xl border-r border-red-100">

        <div class="p-4 text-sm border-b border-red-50" style="background-color: #fef2f2;">
            <span class="text-red-600 font-medium">Login sebagai:</span><br>
            <b class="text-gray-800 text-base">{{ auth()->user()->name }}</b>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

            <a href="{{ route('petugas.dashboard') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/dashboard') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">🏠</span> Dashboard
            </a>

            <div class="mt-6 mb-2 px-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-red-400">Transaksi</p>
            </div>

            <a href="{{ route('petugas.tools') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/tools*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">📦</span> Daftar Alat
            </a>

            <a href="{{ route('petugas.approve-loans') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/approve-loans*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">✅</span> Setujui Peminjaman
            </a>

            <a href="{{ route('petugas.validate-returns') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/validate-returns*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">✔️</span> Validasi Kembali
            </a>

            <div class="mt-6 mb-2 px-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-red-400">Laporan</p>
            </div>

            <a href="{{ route('petugas.reports') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/reports*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">📊</span> Laporan Stok
            </a>

            <a href="{{ route('petugas.laporan-peminjaman') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/laporan-peminjaman*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">📚</span> Lap. Peminjaman
            </a>

            <a href="{{ route('petugas.verify-denda-payments') }}"
               class="flex items-center px-4 py-2.5 rounded-lg transition-all font-semibold border-l-4"
               style="{{ request()->is('petugas/verify-denda-payments*') ? 'background-color: #fee2e2; color: #b91c1c; border-color: #ef4444;' : 'color: #4b5563; border-color: transparent;' }}">
               <span class="mr-3">💰</span> Verifikasi Denda
            </a>
        </nav>

        <div class="p-4 border-t border-red-50 bg-white">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full py-2.5 rounded-xl font-bold transition-all shadow-md hover:shadow-red-200 active:scale-95 text-white" 
                        style="background-color: #dc2626;">
                    🚪 Logout
                </button>
            </form>
        </div>

    </aside>

    <main class="flex-1 p-8 text-gray-900 overflow-x-auto bg-red-50">
        <div class="bg-white p-6 rounded-2xl shadow-sm min-h-full border border-red-100">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
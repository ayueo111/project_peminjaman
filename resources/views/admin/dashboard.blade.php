@extends('layouts.admin')

@section('content')
    <div class="mb-8 rounded-lg p-8 shadow-lg" style="background-color: #a855f7;">
        <h1 class="text-4xl font-bold drop-shadow-md" style="color: #ffffff;">Halo, {{ auth()->user()->name }}!</h1>
        <p class="mt-2 drop-shadow-sm" style="color: #ffffff;">Selamat datang di Dashboard Admin</p>
    </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition"
                style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6;">
                <p class="text-sm font-semibold opacity-90" style="color: #5b21b6;">
                    Total Alat
                </p>
                <p class="text-3xl font-bold mt-2" style="color: #1e1b4b;">
                    {{ \App\Models\Tool::count() }}
                </p>
            </div>

            <div class="rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition"
                style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6;">
                <p class="text-sm font-semibold opacity-90" style="color: #5b21b6;">
                    Total Peminjaman
                </p>
                <p class="text-3xl font-bold mt-2" style="color: #1e1b4b;">
                    {{ \App\Models\Loan::count() }}
                </p>
            </div>

            <div class="rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition"
                style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6;">
                <p class="text-sm font-semibold opacity-90" style="color: #5b21b6;">
                    Alat Dipinjam
                </p>
                <p class="text-3xl font-bold mt-2" style="color: #1e1b4b;">
                    {{ \App\Models\Loan::whereNull('tanggal_kembali')->count() }}
                </p>
            </div>

            <div class="rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition"
                style="background-color: #ddd6fe; border-left: 4px solid #6d28d9;">
                <p class="text-sm font-semibold opacity-90" style="color: #4338ca;">
                    Total Pengguna
                </p>
                <p class="text-3xl font-bold mt-2" style="color: #1e1b4b;">
                    {{ \App\Models\User::count() }}
                </p>
            </div>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-lg shadow-lg p-6" style="background-color: #ede9fe;">
            <h2 class="text-xl font-bold mb-4" style="color: #4c1d95;">Peminjaman Terbaru</h2>
            @php
                $loans = \App\Models\Loan::latest()->take(10)->get();
            @endphp
            <div class="relative">
                <div class="@if($loans->count() > 3) overflow-y-auto @else space-y-3 @endif" 
                     style="@if($loans->count() > 3) max-height: 280px; @endif">
                    <div class="@if($loans->count() > 3) space-y-3 pr-2 @else space-y-3 @endif">
                        @forelse($loans as $loan)
                            <div class="flex items-center justify-between p-3 rounded border border-purple-200" style="background-color: #ffffff;">
                                <div>
                                    <p class="font-semibold" style="color: #1e1b4b;">{{ $loan->user->name ?? 'User' }}</p>
                                    <p class="text-sm" style="color: #6d28d9;">{{ $loan->tool->nama_alat ?? 'Alat' }}</p>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full" style="background-color: #c4b5fd; color: #4c1d95;">
                                    {{ $loan->tanggal_kembali ? 'Dikembalikan' : 'Dipinjam' }}
                                </span>
                            </div>
                        @empty
                            <p style="color: #4c1d95;" class="text-center py-4">Tidak ada peminjaman</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-lg shadow-lg p-6" style="background-color: #ede9fe;">
            <h2 class="text-xl font-bold mb-4" style="color: #4c1d95;">Alat Tersedia</h2>
            @php
                $tools = \App\Models\Tool::where('stok', '>', 0)->take(10)->get();
            @endphp
            <div class="relative">
                <div class="@if($tools->count() > 3) overflow-y-auto @else space-y-3 @endif" 
                     style="@if($tools->count() > 3) max-height: 280px; @endif">
                    <div class="@if($tools->count() > 3) space-y-3 pr-2 @else space-y-3 @endif">
                        @forelse($tools as $tool)
                            <div class="flex items-center justify-between p-3 rounded border border-purple-200" style="background-color: #ffffff;">
                                <div>
                                    <p class="font-semibold" style="color: #1e1b4b;">{{ $tool->nama_alat }}</p>
                                    <p class="text-sm" style="color: #6d28d9;">Stok: {{ $tool->stok }}</p>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full" style="background-color: #c4b5fd; color: #4c1d95;">
                                    Tersedia
                                </span>
                            </div>
                        @empty
                            <p style="color: #4c1d95;" class="text-center py-4">Tidak ada alat tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
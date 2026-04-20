@extends('layouts.petugas')

@section('content')

<div class="mb-8 rounded-lg p-8 shadow-lg" style="background-color: #ef4444;">
    <h1 class="text-4xl font-bold drop-shadow-md" style="color: #ffffff;">Halo, {{ auth()->user()->name }}! 👋</h1>
    <p class="mt-2 drop-shadow-sm" style="color: #ffffff;">Selamat datang di dashboard petugas</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="rounded-lg shadow-lg p-6 border-l-4 border-red-500" style="background-color: #fef2f2;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold" style="color: #991b1b;">⏳ Peminjaman Menunggu</p>
                <p class="text-3xl font-bold mt-2" style="color: #7f1d1d;">
                    {{ \App\Models\Loan::where('status', 'pending')->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-lg shadow-lg p-6 border-l-4 border-red-500" style="background-color: #fef2f2;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold" style="color: #991b1b;">✅ Peminjaman Disetujui</p>
                <p class="text-3xl font-bold mt-2" style="color: #7f1d1d;">
                    {{ \App\Models\Loan::where('status', 'approved')->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-lg shadow-lg p-6 border-l-4 border-red-500" style="background-color: #fef2f2;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold" style="color: #991b1b;">⏳ Pengembalian Menunggu</p>
                <p class="text-3xl font-bold mt-2" style="color: #7f1d1d;">
                    {{ \App\Models\Loan::where('status', 'approved')->whereNull('tanggal_kembali')->count() }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="rounded-lg shadow-lg p-6 border border-red-100" style="background-color: #fff1f2;">
    <h2 class="text-2xl font-bold mb-4" style="color: #991b1b;">📋 Peminjaman Menunggu Persetujuan</h2>

    @php
        $pendingLoans = \App\Models\Loan::where('status', 'pending')
            ->with('user', 'tool')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    @endphp

    @if($pendingLoans->count())
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead style="background-color: #fecaca;">
                    <tr>
                        <th class="px-4 py-2 text-left" style="color: #7f1d1d;">Nama Peminjam</th>
                        <th class="px-4 py-2 text-left" style="color: #7f1d1d;">Alat</th>
                        <th class="px-4 py-2 text-left" style="color: #7f1d1d;">Jumlah</th>
                        <th class="px-4 py-2 text-left" style="color: #7f1d1d;">Tanggal</th>
                        <th class="px-4 py-2 text-left" style="color: #7f1d1d;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingLoans as $loan)
                    <tr class="border-b border-red-100 hover:bg-red-50 transition" style="background-color: #ffffff;">
                        <td class="px-4 py-2" style="color: #374151;">{{ $loan->nama_peminjam }}</td>
                        <td class="px-4 py-2" style="color: #374151;">{{ $loan->tool->nama_alat ?? '-' }}</td>
                        <td class="px-4 py-2" style="color: #374151;">{{ $loan->jumlah }}</td>
                        <td class="px-4 py-2 text-sm" style="color: #6B7280;">{{ $loan->tanggal_pinjam }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('petugas.approve-loans') }}" class="px-3 py-1 rounded font-semibold text-sm transition hover:bg-red-600 hover:text-white" style="background-color: #ef4444; color: #ffffff; text-decoration: none;">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8" style="color: #991b1b;">
            <p class="text-lg">Tidak ada peminjaman menunggu</p>
        </div>
    @endif
</div>

@endsection
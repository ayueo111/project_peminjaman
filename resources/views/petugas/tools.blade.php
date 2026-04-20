@extends('layouts.petugas')

@section('content')
<h1 class="text-3xl font-bold mb-6" style="color: #374151;">📦 Daftar Alat</h1>

<div class="overflow-x-auto rounded shadow" style="background-color: #FFF7E6;">
    <table class="w-full border">
        <thead style="background-color: #DCEBFA;">
            <tr>
                <th class="px-4 py-2" style="color: #374151;">No</th>
                <th class="px-4 py-2" style="color: #374151;">Nama Alat</th>
                <th class="px-4 py-2" style="color: #374151;">Kategori</th>
                <th class="px-4 py-2" style="color: #374151;">Total Alat</th>
                <th class="px-4 py-2" style="color: #374151;">Alat yang dipinjam</th>
                <th class="px-4 py-2" style="color: #374151;">Stok Tersedia</th>
                <th class="px-4 py-2" style="color: #374151;">Status</th>
            </tr>
        </thead>
       <tbody>
            @foreach ($tools as $index => $tool)
                <tr class="border-b">
                    <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-center">{{ $tool->nama_alat }}</td>
                    <td class="px-4 py-2 text-center">{{ $tool->kategori }}</td>

                    <td class="px-4 py-2 text-center">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                            {{ $tool->stok }} unit
                        </span>
                    </td>

                    <td class="px-4 py-2 text-center">
                        {{ $tool->alat_dipinjam ?? 0 }} unit
                    </td>

                    <td class="px-4 py-2 text-center">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
                            {{ $tool->stok_tersedia ?? $tool->stok }} unit
                        </span>
                    </td>

                    <td class="px-4 py-2 text-center">
                        @if(($tool->stok_tersedia ?? $tool->stok) > 0)
                            <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded">Habis</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="rounded shadow p-6" style="background-color: #D9F3DF;">
        <h3 class="text-lg font-semibold text-gray-700">Total Stok</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalStok }} unit</p>
    </div>

    <div class="rounded shadow p-6" style="background-color: #FDE2E2;">
        <h3 class="text-lg font-semibold text-gray-700">Stok Tersedia</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalStokTersedia }} unit</p>
    </div>

</div>
@endsection

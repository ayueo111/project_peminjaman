@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6" style="color: #374151;">Data Alat</h1>

<a href="{{ route('tools.create') }}"
   class="inline-block mb-4 px-4 py-2 rounded font-semibold"
   style="background-color: #CDEDEA; color: #374151;">
   + Tambah Alat
</a>

<div class="overflow-x-auto rounded shadow" style="background-color: #FFF7E6;">
<table class="min-w-full border">
    <thead style="background-color: #DCEBFA;">
        <tr>
            <th class="px-4 py-2" style="color: #374151;">Kode</th>
            <th class="px-4 py-2" style="color: #374151;">Nama Alat</th>
            <th class="px-4 py-2" style="color: #374151;">Kategori</th>
            <th class="px-4 py-2" style="color: #374151;">Total Alat</th>
            <th class="px-4 py-2" style="color: #374151;">Alat yang dipinjam</th>
            <th class="px-4 py-2" style="color: #374151;">Stok Tersedia</th>
            <th class="px-4 py-2" style="color: #374151;">Status</th>
            <th class="px-4 py-2" style="color: #374151;">Aksi</th>
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

                <td class="px-4 py-2 text-center">
                    <a href="{{ route('tools.edit', $tool->id) }}"
                    class="bg-blue-100 text-blue-700 px-3 py-1 rounded">
                        Edit
                    </a>

                    <form action="{{ route('tools.destroy', $tool->id) }}"
                        method="POST"
                        style="display:inline-block;"
                        onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="rounded-lg shadow-2xl p-6 max-w-sm mx-4" style="background-color: #DCEBFA; border: 4px solid #CDEDEA;">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold" style="color: #374151;">Konfirmasi Hapus</h2>
            <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
        </div>
        <p class="mb-6" style="color: #374151;">Yakin ingin menghapus alat <strong id="toolName"></strong>?</p>
        <div class="flex gap-3">
            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2 rounded font-semibold transition" style="background-color: #e74c3c; color: white;">
                    Hapus
                </button>
            </form>
            <button onclick="closeDeleteModal()" class="flex-1 py-2 rounded font-semibold transition" style="background-color: #CDEDEA; color: #374151;">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, name) {
        document.getElementById('toolName').textContent = name;
        document.getElementById('deleteForm').action = `/tools/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>

@endsection

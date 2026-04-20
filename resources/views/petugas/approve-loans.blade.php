@extends('layouts.petugas')

@section('content')
<h1 class="text-3xl font-bold mb-6" style="color: #374151;">Setujui Peminjaman</h1>

<div class="overflow-x-auto rounded shadow" style="background-color: #FFF7E6;">
<table class="w-full border">
    <thead style="background-color: #DCEBFA;">
        <tr>
            <th class="px-4 py-2" style="color: #374151;">No</th>
            <th class="px-4 py-2" style="color: #374151;">Nama Peminjam</th>
            <th class="px-4 py-2" style="color: #374151;">Alat</th>
            <th class="px-4 py-2" style="color: #374151;">Jumlah</th>
            <th class="px-4 py-2" style="color: #374151;">Tanggal Pinjam</th>
            <th class="px-4 py-2" style="color: #374151;">Status</th>
            <th class="px-4 py-2" style="color: #374151;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($loans as $index => $loan)
        <tr class="border-b text-center">
            <td class="px-4 py-2">{{ $index + 1 }}</td>
            <td class="px-4 py-2">{{ $loan->nama_peminjam }}</td>
            <td class="px-4 py-2">{{ $loan->tool->nama_alat ?? '-' }}</td>
            <td class="px-4 py-2">{{ $loan->jumlah }}</td>
            <td class="px-4 py-2">{{ $loan->tanggal_pinjam }}</td>

            <!-- STATUS -->
            <td class="px-4 py-2">
                @if($loan->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded font-semibold text-sm">
                        Menunggu
                    </span>
                @elseif($loan->status === 'approved')
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-semibold text-sm">
                        Disetujui
                    </span>
                @else
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded font-semibold text-sm">
                        Ditolak
                    </span>
                @endif
            </td>

            <!-- AKSI -->
            <td class="px-4 py-2">
                @if($loan->status === 'pending')
                    <button onclick="openApproveModal({{ $loan->id }}, '{{ $loan->nama_peminjam }}')"
                        class="px-2 py-1 rounded font-semibold text-sm"
                        style="background-color: #CDEDEA; color: #374151;">
                        Setujui
                    </button>

                    <button onclick="openRejectModal({{ $loan->id }}, '{{ $loan->nama_peminjam }}')"
                        class="px-2 py-1 rounded font-semibold text-sm"
                        style="background-color: #e74c3c; color: white;">
                        Tolak
                    </button>

                @elseif($loan->status === 'approved')
                    <span class="px-2 py-1 rounded font-semibold text-sm"
                        style="background-color: #CDEDEA; color: #374151;">
                        Sudah Disetujui
                    </span>
                    <br>

                    <a href="{{ route('petugas.cetak-peminjaman', $loan->id) }}" target="_blank"
                        class="px-2 py-1 rounded font-semibold text-sm inline-block mt-1"
                        style="background: #CDEDEA; color: #374151;">
                        🖨️ Cetak
                    </a>

                @else
                    <span class="px-2 py-1 rounded font-semibold text-sm"
                        style="background-color: #f8d7da; color: #721c24;">
                        Ditolak
                    </span>
                @endif
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="7" class="text-center py-4 text-gray-500">
                Tidak ada peminjaman yang menunggu persetujuan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

<!-- Modal Approve -->
<div id="approveModal" style="display: none; position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); align-items: center; justify-content: center; z-index: 50;">
    <div style="border-radius: 0.5rem; padding: 1.5rem; max-width: 28rem; margin: auto; background-color: #DCEBFA; border: 4px solid #CDEDEA;">
        <h2 class="text-lg font-bold mb-2">Setujui Peminjaman</h2>
        <p class="mb-4">Setujui peminjaman untuk <strong id="approveName"></strong></p>

        <form id="approveForm" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-semibold">Durasi (hari)</label>
            <input type="number" name="durasi_hari" min="1" max="90" value="7" required class="w-full p-2 border rounded mb-4">

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-500 text-white py-2 rounded">
                    Setujui
                </button>
                <button type="button" onclick="closeApproveModal()" class="flex-1 bg-gray-200 py-2 rounded">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" style="display: none; position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center;">
    <div style="border-radius: 0.5rem; padding: 1.5rem; max-width: 28rem; background-color: #DCEBFA; border: 4px solid #CDEDEA;">
        <h2 class="text-lg font-bold mb-2">Tolak Peminjaman</h2>
        <p class="mb-4">Tolak peminjaman untuk <strong id="rejectName"></strong>?</p>

        <form id="rejectForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-red-500 text-white py-2 rounded">
                    Tolak
                </button>
                <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-200 py-2 rounded">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const approveRouteTemplate = "{{ route('petugas.approve-loan', ['loan' => ':id']) }}";
const rejectRouteTemplate = "{{ route('petugas.reject-loan', ['loan' => ':id']) }}";

function openApproveModal(id, name) {
    document.getElementById('approveName').textContent = name;
    document.getElementById('approveForm').action = approveRouteTemplate.replace(':id', id);
    document.getElementById('approveModal').style.display = 'flex';
}

function closeApproveModal() {
    document.getElementById('approveModal').style.display = 'none';
}

function openRejectModal(id, name) {
    document.getElementById('rejectName').textContent = name;
    document.getElementById('rejectForm').action = rejectRouteTemplate.replace(':id', id);
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>

@endsection
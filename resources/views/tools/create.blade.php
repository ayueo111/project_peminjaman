@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6 rounded shadow" style="background-color: #DCEBFA;">
    <h1 class="text-3xl font-bold mb-6 text-gray-700">Tambah Alat</h1>

    <form action="{{ route('tools.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama_alat" class="block font-semibold mb-2">Nama Alat</label>
            <input type="text" name="nama_alat" id="nama_alat"
                   class="w-full border rounded px-4 py-2"
                   value="{{ old('nama_alat') }}" required>
        </div>

        <div class="mb-4">
            <label for="kategori" class="block font-semibold mb-2">Kategori</label>
           <select name="category_id" id="category_id" class="w-full border rounded px-4 py-2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="stok" class="block font-semibold mb-2">Total Alat</label>
            <input type="number" name="stok" id="stok"
                   class="w-full border rounded px-4 py-2"
                   value="{{ old('stok') }}" min="0" required>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded">
                Simpan
            </button>

            <a href="{{ route('tools.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
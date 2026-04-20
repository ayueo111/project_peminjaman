<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Helpers\ActivityHelper;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with(['loans' => function ($query) {
            $query->whereIn('status', ['disetujui', 'dipinjam']);
        }])->get();

        foreach ($tools as $tool) {
            $jumlahDipinjam = $tool->loans->sum('jumlah');
            $tool->alat_dipinjam = $jumlahDipinjam;
            $tool->stok_tersedia = $tool->stok - $jumlahDipinjam;
        }

        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            // 'kategori' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
        ]);

        Tool::create([
            'nama_alat' => $request->nama_alat,
            // 'kategori' => $request->kategori,
            'category_id' => $request->category_id,
            'stok' => $request->stok,

            // default supaya tidak error kalau kolom ini masih ada di database
            'kode_alat' => $request->nama_alat . '_' . time(),
            'merk' => '-',
            'lokasi' => '-',
            'kondisi' => 'baik',
            'jurusan' => '-',
        ]);

        return redirect()->route('tools.index')->with('success', 'Data alat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tool = Tool::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            // 'kategori' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
        ]);

        $tool->update([
            'nama_alat' => $request->nama_alat,
            // 'kategori' => $request->kategori,
            'category_id' => $request->category_id,
            'stok' => $request->stok,
        ]);

        return redirect()->route('tools.index')->with('success', 'Data alat berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tool = Tool::findOrFail($id);
        $nama_alat = $tool->nama_alat;
        $tool->delete();
        
        // Catat aktivitas
        ActivityHelper::log('DELETE_ALAT', "Hapus alat: {$nama_alat}");

        return redirect()->route('tools.index')->with('success', 'Alat berhasil dihapus');
    }
}

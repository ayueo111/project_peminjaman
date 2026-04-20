<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Tool;
use App\Helpers\DendaHelper;
use App\Helpers\ActivityHelper;
use Illuminate\Http\Request;
use Mail;
use App\Mail\KirimStruk;
use PDF;

class PetugasController extends Controller
{
    // ================= TOOLS =================
    public function toolsIndex()

    {
       
        $tools = Tool::with(['loans' => function ($query) {
            $query->whereIn('status', ['tersedia', 'tidak tersedia']);
        }])->get();

        foreach ($tools as $tool) {
            $jumlahDipinjam = $tool->loans->sum('jumlah');

            $tool->alat_dipinjam = $jumlahDipinjam;
            $tool->stok_tersedia = $tool->stok - $jumlahDipinjam;
        }

        $totalStok = $tools->sum('stok'); // total semua stok
        $totalStokTersedia = $tools->sum('stok_tersedia'); // total stok tersedia

        return view('petugas.tools', compact(
            'tools',
            'totalStok',
            'totalStokTersedia'
        ));
    }

    // ================= APPROVE =================
    public function approveLoanIndex()
    {
        $loans = Loan::with(['user', 'tool'])
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('petugas.approve-loans', compact('loans'));
    }

    public function approveLoan(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'durasi_hari' => 'required|integer|min:1|max:90'
        ]);

        // 🔥 FIX ERROR STRING → INT
        $durasi = (int) $validated['durasi_hari'];

        $tanggal_pinjam = \Carbon\Carbon::parse($loan->tanggal_pinjam);
        $tanggal_kembali_target = $tanggal_pinjam->copy()->addDays($durasi);

        $loan->update([
            'status' => 'approved',
            'tanggal_kembali_target' => $tanggal_kembali_target
        ]);

        $loan->tool->stok -= $loan->jumlah;
        $loan->tool->save();

        return redirect()->route('petugas.approve-loans')
            ->with('success', 'Peminjaman disetujui');
    }

    public function rejectLoan(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('petugas.approve-loans')->with('success', 'Peminjaman ditolak');
    }

    // ================= VALIDASI =================
    public function validateReturnIndex()
    {
        $loans = Loan::where('status', 'approved')
            ->with(['user', 'tool'])
            ->get();

        return view('petugas.validate-returns', compact('loans'));
    }

    public function validateReturn(Request $request, Loan $loan)
    {
        $request->validate([
            'jumlah_kembali_baik' => 'required|integer|min:0',
            'jumlah_kembali_rusak' => 'required|integer|min:0',
            'jumlah_kembali_hilang' => 'required|integer|min:0',
            'harga_barang' => 'nullable|numeric|min:0'
        ]);

        $baik = (int) $request->jumlah_kembali_baik;
        $rusak = (int) $request->jumlah_kembali_rusak;
        $hilang = (int) $request->jumlah_kembali_hilang;

        $total = $baik + $rusak + $hilang;

        if ($total != $loan->jumlah) {
            return back()->with('error', 'Jumlah tidak sesuai!');
        }

        $harga = (int) ($request->harga_barang ?? 0);

        $denda = 0;
        $ket = [];

        if ($rusak > 0 && $harga > 0) {
            $d = $rusak * $harga * 0.5;
            $denda += $d;
            $ket[] = "Rusak Rp " . number_format($d);
        }

        if ($hilang > 0 && $harga > 0) {
            $d = $hilang * $harga;
            $denda += $d;
            $ket[] = "Hilang Rp " . number_format($d);
        }

        $loan->update([
            'tanggal_kembali' => now(),
            'jumlah_kembali_baik' => $baik,
            'jumlah_kembali_rusak' => $rusak,
            'jumlah_kembali_hilang' => $hilang,
            'harga_barang' => $harga,
            'denda' => $denda,
            'alasan_denda' => implode(', ', $ket) ?: 'Tidak ada denda',
            'status' => 'returned'
        ]);

        // stok balik
        if ($baik > 0) {
            $loan->tool->stok += $baik;
            $loan->tool->save();
        }

        // 🔥 EMAIL + PDF
        try {
            $pdf = PDF::loadView('pdf.struk-pengembalian', [
                'loan' => $loan,
                'tanggal_cetak' => now()
            ])->output();

            Mail::to($loan->user->email)->send(new KirimStruk($pdf));
        } catch (\Exception $e) {
            \Log::error('Email gagal: ' . $e->getMessage());
        }

        return redirect()->route('petugas.validate-returns')
            ->with('success', 'Validasi berhasil & email terkirim');
    }

    // ================= STRUK =================
    public function cetakStrukPengembalian(Loan $loan)
    {
        $pdf = \PDF::loadView('pdf.struk-pengembalian', [
            'loan' => $loan,
            'tanggal_cetak' => now()
        ]);

        return $pdf->download('struk-'.$loan->id.'.pdf');
    }

    public function cetakStrukPeminjaman(Loan $loan)
    {
        $pdf = \PDF::loadView('pdf.struk-peminjaman', [
            'loan' => $loan,
            'tanggal_cetak' => now()
        ]);

        return $pdf->download('struk-'.$loan->id.'.pdf');
    }

    // ================= REPORT =================
    public function reports(Request $request)
    {
        $filter = $request->get('filter', 'all');

        if ($filter === 'pending') {
            $loans = Loan::where('status', 'pending')->with(['user', 'tool'])->get();
        } elseif ($filter === 'approved') {
            $loans = Loan::where('status', 'approved')->with(['user', 'tool'])->get();
        } elseif ($filter === 'rejected') {
            $loans = Loan::where('status', 'rejected')->with(['user', 'tool'])->get();
        } else {
            $loans = Loan::with(['user', 'tool'])->get();
        }

        return view('petugas.reports', compact('loans'));
    }

    // ================= LAPORAN PEMINJAMAN =================
    public function laporanPeminjaman(Request $request)
    {
        $query = Loan::where('status', 'returned')
            ->with(['user', 'tool']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tool_id')) {
            $query->where('tool_id', $request->tool_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_pinjam', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_pinjam', '<=', $request->tanggal_sampai);
        }

        // 🔥 FIX ERROR total()
        $loans = $query->orderBy('tanggal_kembali', 'desc')->paginate(10);

        $users = \App\Models\User::where('role', 'siswa')->get();
        $tools = Tool::all();

        return view('petugas.laporan-peminjaman', compact('loans', 'users', 'tools'));
    }
}
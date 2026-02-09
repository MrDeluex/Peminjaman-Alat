<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])
            ->where('status', 'dipinjam');

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', "%$search%");
                })
                    ->orWhereHas('alat', function ($alatQuery) use ($search) {
                        $alatQuery->where('nama_alat', 'like', "%$search%");
                    });
            });
        }

        $peminjamans = $query->paginate(10);

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }


    public function show(Peminjaman $peminjaman)
    {
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $hariIni = Carbon::today();

        $hariTelat = $hariIni->greaterThan($tanggalRencana)
            ? $tanggalRencana->diffInDays($hariIni)
            : 0;

        $denda = $hariTelat * ($peminjaman->alat->harga_denda ?? 0);

        return view('petugas.pengembalian.show', compact(
            'peminjaman',
            'hariTelat',
            'denda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'jumlah_bermasalah' => 'nullable|integer|min:1',
            'denda_tambahan' => 'nullable|numeric|min:0',
        ]);

        $peminjaman = Peminjaman::with('alat')->findOrFail($request->peminjaman_id);

        // hitung telat & denda telat (anti manipulasi)
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $hariIni = Carbon::today();

        $hariTelat = $hariIni->greaterThan($tanggalRencana)
            ? $tanggalRencana->diffInDays($hariIni)
            : 0;

        $dendaTelat = $hariTelat * ($peminjaman->alat->harga_denda ?? 0);

        $dendaTambahan = (int) ($request->denda_tambahan ?? 0);
        $totalDenda = $dendaTelat + $dendaTambahan;

        // simpan pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => now(),
            'denda_telat' => $dendaTelat,
            'denda_tambahan' => $dendaTambahan,
            'total_denda' => $totalDenda,
        ]);

        // ===== LOGIKA STOK (PENTING) =====
        $jumlahDipinjam = $peminjaman->jumlah;
        $jumlahBermasalah = (int) ($request->jumlah_bermasalah ?? 0);

        if ($jumlahBermasalah > $jumlahDipinjam) {
            return back()->withErrors(['jumlah_bermasalah' => 'Jumlah bermasalah melebihi jumlah dipinjam']);
        }

        $stokBalik = $jumlahDipinjam - $jumlahBermasalah;

        if ($stokBalik > 0) {
            $peminjaman->alat->increment('stok', $stokBalik);
        }

        // update status peminjaman
        $peminjaman->update([
            'status' => 'selesai',
        ]);

        logAktivitas(
            'Pengembalian diproses | ' .
                'Peminjaman #' . $peminjaman->id . ' | ' .
                'Alat: ' . $peminjaman->alat->nama_alat . ' | ' .
                'Qty: ' . $peminjaman->jumlah . ' | ' .
                'Telat: ' . $hariTelat . ' hari | ' .
                'Denda Telat: Rp ' . number_format($dendaTelat, 0, ',', '.') . ' | ' .
                'Denda Tambahan: Rp ' . number_format($dendaTambahan, 0, ',', '.') . ' | ' .
                'Total: Rp ' . number_format($totalDenda, 0, ',', '.')
        );

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diproses. Total denda: Rp ' . number_format($totalDenda, 0, ',', '.'));
    }


    public function history(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.alat']);

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('peminjaman.user', function ($q) use ($search) {
                $q->where('username', 'like', "%$search%");
            })
                ->orWhereHas('peminjaman.alat', function ($q) use ($search) {
                    $q->where('nama_alat', 'like', "%$search%");
                });
        }

        $pengembalians = $query->paginate(10);

        return view('petugas.pengembalian.history', compact('pengembalians'));
    }
}

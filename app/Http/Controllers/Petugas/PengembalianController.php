<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'dipinjam')
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($request->peminjaman_id);

        $tanggalRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $hariIni = Carbon::today();

        // hitung hari telat (AMAN & KONSISTEN)
        $hariTelat = $hariIni->greaterThan($tanggalRencana)
            ? $tanggalRencana->diffInDays($hariIni)
            : 0;

        $denda = $hariTelat * $peminjaman->alat->harga_denda;

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => $hariIni,
            'denda' => $denda,
        ]);

        // stok dikembalikan
        $peminjaman->alat->update([
            'stok' => $peminjaman->alat->stok + $peminjaman->jumlah
        ]);

        // update status peminjaman
        $peminjaman->update([
            'status' => 'selesai'
        ]);

        logAktivitas('Memproses pengembalian alat');

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diselesaikan');
    }

    public function history()
    {
        $pengembalians = \App\Models\Pengembalian::with([
            'peminjaman.user',
            'peminjaman.alat'
        ])->latest()->get();

        return view('petugas.pengembalian.history', compact('pengembalians'));
    }
}

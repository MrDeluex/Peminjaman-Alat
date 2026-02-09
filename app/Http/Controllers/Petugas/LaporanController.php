<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('petugas.laporan.index');
    }

    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])->latest();

        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('tanggal_pinjam', [
                $request->from,
                $request->to
            ]);
        }

        $peminjamans = $query->get();

        return view('petugas.laporan.peminjaman', compact('peminjamans'));
    }


    public function pdfPeminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])->latest();

        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $peminjamans = $query->get();

        $pdf = Pdf::loadView(
            'petugas.laporan.pdf.peminjaman',
            compact('peminjamans')
        )->setPaper('a4', 'landscape');

        logAktivitas('Melakukan Pencetakan Laporan Peminjaman');

        return $pdf->download('laporan-peminjaman.pdf');
    }


    public function pengembalian(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.alat'
        ])->latest('tanggal_pengembalian');

        // filter tanggal pengembalian
        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('tanggal_pengembalian', [
                $request->from,
                $request->to
            ]);
        }

        $pengembalians = $query->get();

        return view('petugas.laporan.pengembalian', compact('pengembalians'));
    }

    public function pdfPengembalian(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.alat'
        ])->latest();

        // (opsional) filter tanggal pengembalian
        if ($request->filled(['from', 'to'])) {
            $query->whereBetween('tanggal_pengembalian', [
                $request->from,
                $request->to
            ]);
        }

        $pengembalians = $query->get();
        
        $pdf = Pdf::loadView('petugas.laporan.pdf.pengembalian', compact('pengembalians'))
            ->setPaper('a4', 'landscape');

        logAktivitas('Melakukan Pencetakan Laporan Pengemalian');

        return $pdf->download('laporan-pengembalian.pdf');
    }

    public function alat(Request $request)
    {
        $query = Alat::with('kategori');

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $alats = $query->orderBy('nama_alat')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('petugas.laporan.alat', compact('alats', 'kategoris'));
    }

    public function Pdfalat(Request $request)
    {
        $query = Alat::with('kategori');

        // Filter kategori ikut kebawa ke PDF
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $alats = $query->orderBy('nama_alat')->get();

        $pdf = Pdf::loadView('petugas.laporan.pdf.alat', [
            'alats' => $alats,
            'filterKategori' => $request->kategori_id
                ? Kategori::find($request->kategori_id)?->nama_kategori
                : null,
        ]);

        logAktivitas('Melakukan Pencetakan Laporan Alat');

        return $pdf->download('laporan-alat.pdf');
    }
}

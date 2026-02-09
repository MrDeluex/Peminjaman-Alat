<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;


class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'aktif');

        $query = Peminjaman::with('alat')
            ->where('user_id', auth()->id());

        if ($tab === 'aktif') {
            $query->whereIn('status', ['menunggu', 'disetujui', 'dipinjam']);
        } else {
            $query->whereIn('status', ['selesai', 'dibatalkan', 'expired', 'ditolak']);
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('peminjam.peminjaman.index', compact('peminjamans', 'tab'));
    }

    public function store(Request $request)
    {
        $alat = Alat::findOrFail($request->alat_id);

        $request->validate([
            'alat_id' => 'required|exists:alats,id',

            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:' . $alat->stok
            ],

            'tanggal_pinjam' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'tanggal_kembali_rencana' => [
                'required',
                'date',
                'after_or_equal:tanggal_pinjam'
            ],

        ], [
            // Pesan untuk required
            'jumlah.required' => 'Jumlah peminjaman wajib diisi.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali_rencana.required' => 'Tanggal kembali rencana wajib diisi.',

            // Pesan format dan logika
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
            'jumlah.max' => 'Jumlah melebihi stok yang tersedia.',

            'tanggal_pinjam.date' => 'Format tanggal pinjam tidak valid.',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu.',

            'tanggal_kembali_rencana.date' => 'Format tanggal kembali tidak valid.',
            'tanggal_kembali_rencana.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal pinjam.',
        ]);


        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        Peminjaman::create([
            'user_id' => auth()->id(),
            'alat_id' => $alat->id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status' => 'menunggu',
        ]);

        logAktivitas('Mengajukan peminjaman alat');

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diajukan');
    }

    public function batal(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan milik user yang login
        if ($peminjaman->user_id != auth()->id()) {
            return back()->with('error', 'Akses ditolak');
        }

        // Hanya boleh dibatalkan jika status masih menunggu
        if ($peminjaman->status != 'menunggu') {
            return back()->with('error', 'Peminjaman tidak bisa dibatalkan karena sudah diproses');
        }

        $peminjaman->update([
            'status' => 'dibatalkan',
            'alasan_batal' => $request->alasan_batal
        ]);

        logAktivitas('Membatalkan peminjaman alat');

        return back()->with('success', 'Peminjaman berhasil dibatalkan');
    }
}

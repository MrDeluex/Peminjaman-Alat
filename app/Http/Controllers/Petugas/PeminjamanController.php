<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $alat = $peminjaman->alat;

        if ($peminjaman->jumlah > $alat->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $alat->decrement('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'disetujui'
        ]);

        logAktivitas('Menyetujui peminjaman alat');

        return back()->with('success', 'Peminjaman disetujui. Silakan peminjam mengambil alat.');
    }

    public function serahkan($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        $peminjaman->update([
            'status' => 'dipinjam'
        ]);

        logAktivitas('Menyerahkan alat ke peminjam');


        return back()->with('success', 'Alat berhasil diserahkan ke peminjam');
    }

    public function reject($id)
    {
        Peminjaman::findOrFail($id)->update([
            'status' => 'ditolak'
        ]);

        logAktivitas('Menolak peminjaman alat');

        return back()->with('success', 'Peminjaman ditolak');
    }
}

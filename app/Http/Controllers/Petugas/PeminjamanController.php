<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{

    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['menunggu', 'disetujui']);
        }

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

        $statuses = ['menunggu', 'disetujui', 'ditolak', 'dipinjam', 'selesai', 'expired'];

        return view('petugas.peminjaman.index', compact('peminjamans', 'statuses'));
    }



public function approve($id)
{
    $peminjaman = Peminjaman::with('alat')->findOrFail($id);

    $alat = $peminjaman->alat;

    if ($peminjaman->jumlah > $alat->stok) {
        return back()->with('error', 'Stok tidak mencukupi');
    }

    $alat->decrement('stok', $peminjaman->jumlah);

    $peminjaman->update([
        'status' => 'disetujui',
        'disetujui_oleh' => auth()->id(),
    ]);

    logAktivitas(
        'Peminjaman disetujui | ' .
        'Peminjaman #' . $peminjaman->id . ' | ' .
        'Alat: ' . $alat->nama_alat . ' | ' .
        'Qty: ' . $peminjaman->jumlah . ' | ' .
        'Disetujui oleh: ' . auth()->user()->name
    );

    return back()->with('success', 'Peminjaman disetujui.');
}


    public function serahkan($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        $peminjaman->update([
            'status' => 'dipinjam'
        ]);

        logAktivitas(
            'Alat diserahkan ke peminjam | ' .
                'Peminjaman #' . $peminjaman->id . ' | ' .
                'Alat: ' . $peminjaman->alat->nama_alat . ' | ' .
                'Qty: ' . $peminjaman->jumlah
        );

        return back()->with('success', 'Alat berhasil diserahkan ke peminjam');
    }

public function reject(Request $request, $id)
{
    $request->validate([
        'alasan_batal' => 'required|string|max:500'
    ]);

    $peminjaman = Peminjaman::with('alat')->findOrFail($id);

    $peminjaman->update([
        'status' => 'ditolak',
        'alasan_batal' => $request->alasan_batal,
        'disetujui_oleh' => auth()->id() // ⬅ tambahkan ini
    ]);

    logAktivitas(
        'Peminjaman ditolak | ' .
        'Peminjaman #' . $peminjaman->id . ' | ' .
        'Alat: ' . $peminjaman->alat->nama_alat . ' | ' .
        'Qty: ' . $peminjaman->jumlah . ' | ' .
        'Alasan: ' . $request->alasan_batal . ' | ' .
        'Ditolak oleh: ' . auth()->user()->name
    );

    return back()->with('success', 'Peminjaman ditolak');
}

}

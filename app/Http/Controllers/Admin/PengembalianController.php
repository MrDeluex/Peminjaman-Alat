<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
public function index(Request $request)
{
    $query = Pengembalian::with(['peminjaman.user', 'peminjaman.alat']);

    if ($request->filled('search')) {
        $query->whereHas('peminjaman.user', function ($q) use ($request) {
            $q->where('username', 'like', '%' . $request->search . '%');
        })->orWhereHas('peminjaman.alat', function ($q) use ($request) {
            $q->where('nama_alat', 'like', '%' . $request->search . '%');
        });
    }

    $pengembalians = $query->latest()->paginate();

    return view('admin.pengembalian.index', compact('pengembalians'));
}

}

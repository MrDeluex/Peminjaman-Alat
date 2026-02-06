<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.alat'
        ])
        ->whereHas('peminjaman', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->latest()
        ->get();

        return view('peminjam.pengembalian.index', compact('pengembalians'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.user', 'peminjaman.alat')
            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }
}

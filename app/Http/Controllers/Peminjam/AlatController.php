<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->get();

        return view('peminjam.alat.index', compact('alats'));
    }

    public function show($id)
    {
        $alat = Alat::with('kategori')->findOrFail($id);

        return view('peminjam.alat.show', compact('alat'));
    }
}

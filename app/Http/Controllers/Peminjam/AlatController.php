<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        // Search
        if ($request->search) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        $alats = $query->paginate(10)->withQueryString();

        $kategoris = Kategori::all();

        return view('peminjam.alat.index', compact('alats', 'kategoris'));
    }


    public function show($id)
    {
        $alat = Alat::with('kategori')->findOrFail($id);

        return view('peminjam.alat.show', compact('alat'));
    }
}

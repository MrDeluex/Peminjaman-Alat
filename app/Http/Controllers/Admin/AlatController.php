<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $alats = $query->latest()->paginate(10);
        $kategoris = Kategori::orderBy('nama_kategori')->paginate(10);

        return view('admin.alat.index', compact('alats', 'kategoris'));
    }


    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'harga_denda' => 'required|integer|min:0',
        ], [
            'nama_alat.required'   => 'Nama alat wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'stok.required'        => 'Stok wajib diisi',
            'harga_denda.required' => 'Denda per hari wajib diisi',
        ]);

        Alat::create($request->all());

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'harga_denda' => 'required|integer|min:0',
        ], [
            'nama_alat.required'   => 'Nama alat wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'stok.required'        => 'Stok wajib diisi',
            'harga_denda.required' => 'Denda per hari wajib diisi',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update($request->all());

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil diupdate');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil dihapus');
    }
}

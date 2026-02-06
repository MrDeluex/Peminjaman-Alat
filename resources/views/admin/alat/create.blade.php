@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Tambah Alat</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.alat.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Alat</label>
                    <input type="text" name="nama_alat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" required>
                </div>

                <div class="mb-3">
                    <label>Denda per Hari</label>
                    <input type="number" name="harga_denda" class="form-control" min="0" required>
                </div>


                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection

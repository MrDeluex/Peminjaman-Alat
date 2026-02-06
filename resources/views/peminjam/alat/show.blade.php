@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Alat</h5>
    </div>

    <div class="card-body">
        <p><strong>Nama Alat:</strong> {{ $alat->nama }}</p>
        <p><strong>Kategori:</strong> {{ $alat->kategori->nama }}</p>
        <p><strong>Stok Tersedia:</strong> {{ $alat->stok }}</p>

        <hr>

        <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
            @csrf
            <input type="hidden" name="alat_id" value="{{ $alat->id }}">

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah"
                       class="form-control"
                       min="1" max="{{ $alat->stok }}" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Kembali Rencana</label>
                <input type="date" name="tanggal_kembali_rencana"
                       class="form-control" required>
            </div>

            <button class="btn btn-primary">Ajukan Peminjaman</button>
            <a href="{{ route('peminjam.alat.index') }}"
               class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection

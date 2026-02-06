@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Kategori</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="form-control" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection

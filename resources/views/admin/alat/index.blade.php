@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Data Alat</h5>
        <a href="{{ route('admin.alat.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alats as $alat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $alat->nama_alat }}</td>
                    <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $alat->stok }}</td>
                    <td>
                        <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus alat ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

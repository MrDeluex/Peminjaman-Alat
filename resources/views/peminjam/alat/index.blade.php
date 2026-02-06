@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Daftar Alat</h5>
    </div>

    <div class="card-body">
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
                    <td>{{ $alat->kategori->nama_kategori }}</td>
                    <td>{{ $alat->stok }}</td>
                    <td>
                        <a href="{{ route('peminjam.alat.show', $alat->id) }}"
                           class="btn btn-primary btn-sm">
                           Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>History Pengembalian</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengembalians as $p)
                <tr>
                    <td>{{ $p->peminjaman->user->username }}</td>
                    <td>{{ $p->peminjaman->alat->nama_alat }}</td>
                    <td>{{ $p->peminjaman->jumlah }}</td>
                    <td>{{ $p->tanggal_pengembalian }}</td>
                    <td>Rp {{ number_format($p->denda) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

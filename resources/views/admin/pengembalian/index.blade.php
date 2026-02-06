@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Data Pengembalian</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Tgl Pengembalian</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengembalians as $kembali)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kembali->peminjaman->user->username }}</td>
                    <td>{{ $kembali->peminjaman->alat->nama }}</td>
                    <td>{{ $kembali->peminjaman->jumlah }}</td>
                    <td>{{ $kembali->tanggal_pengembalian }}</td>
                    <td>Rp {{ number_format($kembali->denda) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

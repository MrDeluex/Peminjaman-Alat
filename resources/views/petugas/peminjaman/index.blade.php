@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Pengajuan Peminjaman</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjamans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->user->username }}</td>
                            <td>{{ $p->alat->nama_alat }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>
                                @if ($p->status === 'menunggu')
                                    <form action="{{ route('petugas.peminjaman.approve', $p->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                @endif

                                @if ($p->status === 'disetujui')
                                    <form action="{{ route('petugas.peminjaman.serahkan', $p->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">Serahkan Alat</button>
                                    </form>
                                @endif

                                <form action="/petugas/peminjaman/{{ $p->id }}/reject" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

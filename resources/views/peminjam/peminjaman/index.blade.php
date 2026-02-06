@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Riwayat Peminjaman</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->alat->nama_alat }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>
                        @if($p->status == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($p->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="badge bg-primary">Dipinjam</span>
                        @elseif($p->status == 'selesai')
                            <span class="badge bg-secondary">Selesai</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status == 'disetujui')
                            <span class="text-success">
                                ✔ Peminjaman disetujui, silakan ambil alat Anda
                            </span>
                        @elseif($p->status == 'menunggu')
                            <span class="text-muted">
                                ⏳ Menunggu persetujuan petugas
                            </span>
                        @elseif($p->status == 'dipinjam')
                            <span class="text-primary">
                                📦 Alat sedang dipinjam
                            </span>
                        @elseif($p->status == 'selesai')
                            <span class="text-secondary">
                                🔁 Peminjaman telah selesai
                            </span>
                        @else
                            <span class="text-danger">
                                ❌ Peminjaman ditolak
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

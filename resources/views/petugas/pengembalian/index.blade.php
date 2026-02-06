@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Pengembalian Alat</h5>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Batas Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjamans as $p)
                        @php
                            $tanggalRencana = \Carbon\Carbon::parse($p->tanggal_kembali_rencana);
                            $hariIni = \Carbon\Carbon::today();

                            $hariTelat = $hariIni->greaterThan($tanggalRencana)
                                ? $tanggalRencana->diffInDays($hariIni)
                                : 0;

                            $denda = $hariTelat * $p->alat->harga_denda;
                        @endphp
                        <tr>
                            <td>{{ $p->user->username }}</td>
                            <td>{{ $p->alat->nama }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>{{ $p->tanggal_kembali_rencana }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modal{{ $p->id }}">
                                    Proses
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL -->
                        <div class="modal fade" id="modal{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Peminjam:</strong> {{ $p->user->username }}</p>
                                        <p><strong>Alat:</strong> {{ $p->alat->nama }}</p>
                                        <p><strong>Jumlah:</strong> {{ $p->jumlah }}</p>
                                        <p><strong>Tanggal Kembali:</strong> {{ \Carbon\Carbon::today()->toDateString() }}
                                        </p>
                                        <p><strong>Hari Telat:</strong> {{ $hariTelat }} hari</p>
                                        <p>
                                            <strong>Harga Denda per Hari:</strong>
                                            Rp {{ number_format($p->alat->harga_denda, 0, ',', '.') }}/hari
                                        </p>
                                        <p><strong>Total Denda:</strong> Rp {{ number_format($denda) }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('petugas.pengembalian.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="peminjaman_id" value="{{ $p->id }}">
                                            <button class="btn btn-primary">
                                                Selesaikan Peminjaman
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

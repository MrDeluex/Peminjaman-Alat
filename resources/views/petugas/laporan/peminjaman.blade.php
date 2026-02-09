@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Peminjaman</h1>
            <p class="text-sm text-gray-500">Rekap seluruh data peminjaman</p>
        </div>

        <form method="GET" action="{{ route('petugas.laporan.peminjaman') }}" class="flex flex-wrap items-end gap-3 mb-4">

            <div>
                <label class="text-sm text-gray-600">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-2 py-1 text-sm">
            </div>

            <div>
                <label class="text-sm text-gray-600">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-2 py-1 text-sm">
            </div>

            <button class="px-3 py-2 bg-gray-800 text-white rounded text-sm">
                Terapkan Filter
            </button>

            <a href="{{ route('petugas.laporan.peminjaman') }}" class="px-3 py-2 bg-gray-200 rounded text-sm">
                Reset
            </a>

            {{-- Tombol PDF ikut query filter --}}
            <a href="{{ route('petugas.laporan.peminjaman.pdf', request()->query()) }}"
                class="ml-auto px-4 py-2 rounded bg-red-600 text-white text-sm">
                📄 Cetak PDF
            </a>
        </form>

    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <h2 class="font-semibold text-gray-800">Tabel Peminjaman</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Peminjam</th>
                        <th class="px-4 py-3 text-left">Alat</th>
                        <th class="px-4 py-3 text-left">Jumlah</th>
                        <th class="px-4 py-3 text-left">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-left">Tgl Rencana Kembali</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($peminjamans as $p)
                        <tr>
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $p->user->username ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->alat->nama_alat ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->jumlah }}</td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded text-xs
                                @if ($p->status == 'menunggu') bg-gray-100 text-gray-700
                                @elseif($p->status == 'disetujui') bg-blue-100 text-blue-700
                                @elseif($p->status == 'dibatalkan') bg-red-100 text-red-700
                                @elseif($p->status == 'expired') bg-red-100 text-red-700
            @elseif($p->status == 'ditolak') bg-red-100 text-red-700
                                @elseif($p->status == 'dipinjam') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Style khusus print --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection

@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Pengembalian</h1>
            <p class="text-sm text-gray-500">Rekap seluruh data pengembalian</p>
        </div>

        <form method="GET" action="{{ route('petugas.laporan.pengembalian') }}" class="flex flex-wrap items-end gap-3 mb-4">

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

            <a href="{{ route('petugas.laporan.pengembalian') }}" class="px-3 py-2 bg-gray-200 rounded text-sm">
                Reset
            </a>

            {{-- Tombol PDF ikut query filter --}}
            <a href="{{ route('petugas.laporan.pengembalian.pdf', request()->query()) }}"
                class="ml-auto px-4 py-2 rounded bg-red-600 text-white text-sm">
                📄 Cetak PDF
            </a>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <h2 class="font-semibold text-gray-800">Tabel Pengembalian</h2>
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
                        <th class="px-4 py-3 text-left">Tgl Pengembalian</th>
                        <th class="px-4 py-3 text-left">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($pengembalians as $p)
                        <tr>
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $p->peminjaman->user->username ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->peminjaman->alat->nama_alat ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->peminjaman->jumlah ?? '-' }}</td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($p->peminjaman->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                    Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data pengembalian
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Style khusus print (optional, kalau suatu saat butuh print HTML) --}}
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

@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Data Pengembalian</h1>
                <p class="text-sm text-gray-500">
                    Riwayat pengembalian alat oleh peminjam
                </p>
            </div>
        </div>

        {{-- Search --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / alat..."
                class="border rounded-lg px-3 py-2 text-sm">

            <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
                Cari
            </button>

            <a href="{{ route('admin.pengembalian.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600">
                Reset
            </a>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-center w-[60px]">No</th>
                        <th class="px-6 py-3 text-left">Peminjam</th>
                        <th class="px-6 py-3 text-left">Alat</th>
                        <th class="px-6 py-3 text-center w-[100px]">Jumlah</th>
                        <th class="px-6 py-3 text-left">Tgl Pengembalian</th>
                        <th class="px-6 py-3 text-right w-[180px]">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pengembalians as $kembali)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $pengembalians->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $kembali->peminjaman->user->username ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $kembali->peminjaman->alat->nama_alat ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $kembali->peminjaman->jumlah ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($kembali->tanggal_pengembalian)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-900">
                                @if ($kembali->total_denda > 0)
                                    Rp {{ number_format($kembali->total_denda, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-500 italic">Tidak ada denda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Data pengembalian tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($pengembalians->hasPages())
                <div class="p-4 border-t">
                    {{ $pengembalians->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

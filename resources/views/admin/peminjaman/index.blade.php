@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Peminjaman</h1>
            <p class="text-sm text-gray-500">
                Kelola data peminjaman alat dalam sistem
            </p>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama peminjam / alat..."
               class="border rounded-lg px-3 py-2 text-sm">

        <select name="status" class="border rounded-lg pl-3 pr-8 py-2 text-sm">
            <option value="">Semua Status</option>
            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>

        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
            Cari
        </button>

        <a href="{{ route('admin.peminjaman.index') }}"
           class="px-4 py-2 border rounded-lg text-sm text-gray-600">
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
                    <th class="px-6 py-3 text-left">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-left">Tgl Kembali</th>
                    <th class="px-6 py-3 text-center w-[140px]">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $peminjamans->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $p->user->username ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $p->alat->nama_alat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $p->jumlah }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status == 'menunggu')
                                <span class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                    Menunggu
                                </span>
                            @elseif($p->status == 'disetujui')
                                <span class="px-3 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                    Disetujui
                                </span>
                            @elseif($p->status == 'dibatalkan')
                                <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Dibatalkan
                                </span>
                            @elseif($p->status == 'ditolak')
                                <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @elseif($p->status == 'expired')
                                <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                    expired
                                </span>
                            @elseif($p->status == 'dipinjam')
                                <span class="px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    Dipinjam
                                </span>
                            @elseif($p->status == 'selesai')
                                <span class="px-3 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Data peminjaman tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($peminjamans->hasPages())
            <div class="p-4 border-t">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

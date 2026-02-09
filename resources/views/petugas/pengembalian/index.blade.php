@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Pengembalian</h1>
        <p class="text-sm text-gray-500">Kelola Pengembalian Barang dan Hitung Denda</p>
    </div>

    <form method="GET" action="{{ route('petugas.pengembalian.index') }}" 
          class="flex items-end gap-3">

        <div>
            <label class="text-sm text-gray-600">Cari</label>
            <input type="text" name="search" 
                value="{{ request('search') }}"
                placeholder="Nama peminjam / alat"
                class="border rounded px-3 py-1 text-sm w-52">
        </div>

        <button class="px-3 py-2 bg-gray-800 text-white rounded text-sm">
            Cari
        </button>

        <a href="{{ route('petugas.pengembalian.index') }}" 
           class="px-3 py-2 bg-gray-200 rounded text-sm">
            Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left w-[60px]">No</th>
                <th class="px-4 py-3 text-left">Peminjam</th>
                <th class="px-4 py-3 text-left">Alat</th>
                <th class="px-4 py-3 text-left">Jumlah</th>
                <th class="px-4 py-3 text-left">Batas Kembali</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($peminjamans as $p)
                <tr>
                    <td class="px-6 py-4">{{ $peminjamans->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3">{{ $p->user->username }}</td>
                    <td class="px-4 py-3">{{ $p->alat->nama_alat }}</td>
                    <td class="px-4 py-3">{{ $p->jumlah }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('petugas.pengembalian.show', $p->id) }}"
                           class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                            Proses
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada yang bisa dikembalikan
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
@endsection

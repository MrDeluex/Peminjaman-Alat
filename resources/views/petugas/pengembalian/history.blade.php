@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">History Pengembalian</h1>
        <p class="text-sm text-gray-500">Riwayat data alat yang telah dikembalikan</p>
    </div>

    <form method="GET" action="{{ route('petugas.pengembalian.history') }}" 
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

        <a href="{{ route('petugas.pengembalian.history') }}" 
           class="px-3 py-2 bg-gray-200 rounded text-sm">
            Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left w-[60px]">No</th>
                    <th class="px-4 py-3 text-left">Peminjam</th>
                    <th class="px-4 py-3 text-left">Alat</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-left">Denda</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($pengembalians as $p)
                <tr>
                    <td class="px-4 py-3"> {{ $pengembalians->firstItem() + $loop->index }}</td>

                    <td class="px-4 py-3">
                        {{ $p->peminjaman->user->username }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $p->peminjaman->alat->nama_alat }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                            {{ $p->peminjaman->jumlah }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        {{ $p->tanggal_pengembalian }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs 
                            {{ $p->denda > 0 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            Rp {{ number_format($p->total_denda) }}
                        </span>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Belum ada data history pengembalian
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

@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengembalian</h1>
            <p class="text-sm text-gray-500">Daftar seluruh pengembalian alat yang telah Anda lakukan</p>
        </div>

        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari alat..."
                class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring">

            <button class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg">
                Cari
            </button>

            @if (request('search'))
                <a href="{{ route('peminjam.pengembalian.index') }}" class="px-4 py-2 bg-gray-200 text-sm rounded-lg">
                    Reset
                </a>
            @endif
        </form>
    </div>


    <div class="bg-white rounded-lg shadow">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left w-[60px]">No</th>
                        <th class="px-6 py-3 text-left">Alat</th>
                        <th class="px-6 py-3 text-left">Jumlah</th>
                        <th class="px-6 py-3 text-left">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left">Denda</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($pengembalians as $p)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $pengembalians->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $p->peminjaman->alat->nama_alat }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $p->peminjaman->jumlah }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($p->total_denda > 0)
                                    <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                        Rp {{ number_format($p->total_denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                        Tidak Ada
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                Belum ada riwayat pengembalian
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

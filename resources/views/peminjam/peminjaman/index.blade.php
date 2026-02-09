@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $tab === 'aktif' ? 'Peminjaman Aktif' : 'Riwayat Peminjaman' }}
            </h1>

            <p class="text-sm text-gray-500">
                {{ $tab === 'aktif' ? 'Status peminjaman yang sedang berjalan' : 'Daftar seluruh riwayat peminjaman Anda' }}
            </p>

        </div>

        <a href="{{ route('peminjam.alat.index') }}"
            class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-900 transition">
            + Ajukan Peminjaman Baru
        </a>
    </div>

    <div class="mb-4 border-b">
        <nav class="flex gap-6 text-sm font-medium">
            <a href="{{ route('peminjam.peminjaman.index', ['tab' => 'aktif']) }}"
                class="pb-3
           {{ $tab === 'aktif' ? 'border-b-2 border-gray-800 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                Peminjaman Aktif
            </a>

            <a href="{{ route('peminjam.peminjaman.index', ['tab' => 'riwayat']) }}"
                class="pb-3
           {{ $tab === 'riwayat' ? 'border-b-2 border-gray-800 text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
                Riwayat Peminjaman
            </a>
        </nav>
    </div>


    <div class="bg-white rounded-lg shadow">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left w-[60px]">No</th>
                        <th class="px-6 py-3 text-left">Nama Alat</th>
                        <th class="px-6 py-3 text-left">Jumlah</th>
                        <th class="px-6 py-3 text-left">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Informasi</th>
                        @if ($tab === 'aktif')
                            <th class="px-6 py-3 text-left">Aksi</th>
                        @endif

                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($peminjamans as $p)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $peminjamans->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $p->alat->nama_alat }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $p->jumlah }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($p->status == 'menunggu')
                                    <span class="px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                        Menunggu
                                    </span>
                                @elseif($p->status == 'disetujui')
                                    <span class="px-3 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Disetujui
                                    </span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="px-3 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                        Dipinjam
                                    </span>
                                @elseif($p->status == 'selesai')
                                    <span class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                        Selesai
                                    </span>
                                @elseif($p->status == 'dibatalkan')
                                    <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Dibatalkan
                                    </span>
                                @elseif($p->status == 'expired')
                                    <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Expired
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @if ($p->status == 'disetujui')
                                    <span class="text-green-600">
                                        Peminjaman disetujui, silakan ambil alat Anda
                                    </span>
                                @elseif($p->status == 'menunggu')
                                    <span class="text-gray-500">
                                        Menunggu persetujuan petugas
                                    </span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="text-blue-600">
                                        Alat sedang dipinjam
                                    </span>
                                @elseif($p->status == 'selesai')
                                    <span class="text-gray-600">
                                        Peminjaman telah selesai
                                    </span>
                                @elseif($p->status == 'dibatalkan')
                                    <span class="text-red-600">
                                        Peminjaman telah dibatalkan oleh peminjam
                                    </span>
                                @elseif($p->status == 'expired')
                                    <span class="text-red-600">
                                        Peminjaman telah kadaluarsa
                                    </span>
                                @else
                                    <span class="text-red-600">
                                        Peminjaman ditolak
                                    </span>
                                @endif
                            </td>

                            @if ($tab === 'aktif')
                            <td class="px-6 py-4">
                                @if ($p->status == 'menunggu')
                                    <button
                                        onclick="openConfirmModal({
                                            url: '{{ route('peminjaman.batal', $p->id) }}',
                                            method: 'PUT',
                                            title: 'Batalkan Peminjaman',
                                            message: 'Apakah Anda yakin ingin membatalkan peminjaman alat ini?',
                                            confirmText: 'Ya, Batalkan',
                                            confirmClass: 'bg-red-600 hover:bg-red-700'
                                        })"
                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                        Batalkan
                                    </button>
                                @endif
                            </td>
                            @endif
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada riwayat peminjaman
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

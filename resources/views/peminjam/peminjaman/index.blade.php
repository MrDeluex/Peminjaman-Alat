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
                        <th class="px-6 py-3 text-left">Aksi</th>

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

                            <td class="px-6 py-4 flex gap-2">

                                <!-- Detail -->
                                <button
                                    onclick="openDetailModal(
            '{{ $p->alat->nama_alat }}',
            '{{ $p->jumlah }}',
            '{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}',
            '{{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}',
            '{{ $p->status }}',
            `{{ $p->approver->username ?? '-' }}`,
            `{{ $p->alasan_batal ?? '-' }}`,
            `{{ $p->keterangan ?? '-' }}`,
            `{{ $p->pengembalian->total_denda ?? 0 }}`

        )"
                                    class="px-3 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700 transition">
                                    Detail
                                </button>

                                @if ($tab === 'aktif' && $p->status == 'menunggu')
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
    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Detail Peminjaman
            </h2>

            <div class="space-y-3 text-sm text-gray-700">

                <div>
                    <span class="font-medium">Nama Alat:</span>
                    <p id="detail_nama"></p>
                </div>

                <div>
                    <span class="font-medium">Jumlah:</span>
                    <p id="detail_jumlah"></p>
                </div>

                <div>
                    <span class="font-medium">Tanggal Pinjam:</span>
                    <p id="detail_pinjam"></p>
                </div>

                <div>
                    <span class="font-medium">Tanggal Kembali:</span>
                    <p id="detail_kembali"></p>
                </div>

                <div>
                    <span class="font-medium">Status:</span>
                    <p id="detail_status"></p>
                </div>
                <div>
                    <span class="font-medium">Keterangan:</span>
                    <p id="detail_keterangan"></p>
                </div>
                <div>
                    <span class="font-medium">Petugas:</span>
                    <p id="detail_approver"></p>
                </div>
                <div id="denda_wrapper" class="hidden">
                    <span class="font-medium text-red-600">Total Denda:</span>
                    <p id="detail_denda" class="text-red-600 font-semibold"></p>
                </div>



                <div id="alasan_wrapper" class="hidden">
                    <span class="font-medium text-red-600">Alasan Penolakan:</span>
                    <p id="detail_alasan" class="text-red-600"></p>
                </div>

            </div>

            <div class="mt-6 text-right">
                <button onclick="closeDetailModal()"
                    class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300 transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <script>
        function openDetailModal(nama, jumlah, pinjam, kembali, status, approver, alasan, keterangan, total_denda) {

            document.getElementById('detail_nama').innerText = nama;
            document.getElementById('detail_jumlah').innerText = jumlah;
            document.getElementById('detail_pinjam').innerText = pinjam;
            document.getElementById('detail_kembali').innerText = kembali;
            document.getElementById('detail_status').innerText = status;
            document.getElementById('detail_approver').innerText = approver;
            document.getElementById('detail_keterangan').innerText = keterangan;

            // Alasan penolakan
            if (status === 'ditolak') {
                document.getElementById('alasan_wrapper').classList.remove('hidden');
                document.getElementById('detail_alasan').innerText = alasan;
            } else {
                document.getElementById('alasan_wrapper').classList.add('hidden');
            }

            // Total denda (hanya jika ada dan > 0)
            if (total_denda && total_denda > 0) {
                document.getElementById('denda_wrapper').classList.remove('hidden');
                document.getElementById('detail_denda').innerText =
                    'Rp ' + Number(total_denda).toLocaleString('id-ID');
            } else {
                document.getElementById('denda_wrapper').classList.add('hidden');
            }

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
@endsection

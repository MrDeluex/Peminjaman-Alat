@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Peminjaman</h1>
            <p class="text-sm text-gray-500">Kelola dan filter data peminjaman alat</p>
        </div>

        <form method="GET" action="{{ route('petugas.peminjaman.index') }}" class="flex flex-wrap items-end gap-3">

            <div>
                <label class="text-sm text-gray-600">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama peminjam / alat"
                    class="border rounded px-3 py-1 text-sm w-52">
            </div>

            <div>
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="border rounded pl-2 pr-8 py-1 text-sm">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-3 py-2 bg-gray-800 text-white rounded text-sm">
                Filter
            </button>

            <a href="{{ route('petugas.peminjaman.index') }}" class="px-3 py-2 bg-gray-200 rounded text-sm">
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
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($peminjamans as $p)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $peminjamans->firstItem() + $loop->index }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $p->user->username ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $p->alat->nama_alat ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                                    {{ $p->jumlah }}
                                </span>
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

                            <td class="px-4 py-3">
                                @if (in_array($p->status, ['menunggu', 'disetujui']))
                                    <button type="button"
                                        onclick="openProcessModal(
                '{{ $p->id }}',
                '{{ $p->alat->nama_alat }}',
                '{{ $p->jumlah }}',
                '{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}',
                '{{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}',
                '{{ $p->status }}',
                `{{ $p->keterangan ?? '-' }}`
            )"
                                        class="px-3 py-1 bg-gray-800 text-white text-xs rounded hover:bg-gray-900 transition">
                                        Proses
                                    </button>
                                @endif
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                Belum ada pengajuan peminjaman
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

    <!-- Modal Proses -->
    <div id="processModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Detail Peminjaman
            </h2>

            <div class="space-y-3 text-sm text-gray-700 mb-6">

                <div>
                    <span class="font-medium">Nama Alat:</span>
                    <p id="pm_nama"></p>
                </div>

                <div>
                    <span class="font-medium">Jumlah:</span>
                    <p id="pm_jumlah"></p>
                </div>

                <div>
                    <span class="font-medium">Tanggal Pinjam:</span>
                    <p id="pm_pinjam"></p>
                </div>

                <div>
                    <span class="font-medium">Tanggal Jatuh Tempo:</span>
                    <p id="pm_kembali"></p>
                </div>

                <div>
                    <span class="font-medium">Keterangan:</span>
                    <div class="mt-1 p-3 bg-gray-50 rounded">
                        <p id="pm_keterangan"></p>
                    </div>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 flex-wrap">

                <form id="approveForm" method="POST" class="hidden">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                        Setujui
                    </button>
                </form>

                <form id="serahkanForm" method="POST" class="hidden">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                        Serahkan Alat
                    </button>
                </form>

                <button type="button" id="rejectButton" onclick="openRejectModalFromProcess()"
                    class="hidden px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                    Reject
                </button>

                <button type="button" onclick="closeProcessModal()"
                    class="px-4 py-2 bg-gray-200 text-sm rounded hover:bg-gray-300 transition">
                    Tutup
                </button>

            </div>

        </div>
    </div>


    <!-- Modal Reject -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-1/2 max-w-md p-6 relative">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Alasan Penolakan
            </h2>

            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-2">
                        Berikan alasan penolakan
                    </label>
                    <textarea name="alasan_batal" id="alasan_batal" rows="4" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none"
                        placeholder="Masukkan alasan penolakan..."></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Kirim
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        let currentId = null;

        function openProcessModal(id, nama, jumlah, pinjam, kembali, status, keterangan) {

            currentId = id;

            document.getElementById('pm_nama').innerText = nama;
            document.getElementById('pm_jumlah').innerText = jumlah;
            document.getElementById('pm_pinjam').innerText = pinjam;
            document.getElementById('pm_kembali').innerText = kembali;
            document.getElementById('pm_keterangan').innerText = keterangan;

            const approveForm = document.getElementById('approveForm');
            const serahkanForm = document.getElementById('serahkanForm');
            const rejectButton = document.getElementById('rejectButton');

            approveForm.classList.add('hidden');
            serahkanForm.classList.add('hidden');
            rejectButton.classList.add('hidden');

            if (status === 'menunggu') {
                approveForm.action = `/petugas/peminjaman/${id}/approve`;
                approveForm.classList.remove('hidden');
                rejectButton.classList.remove('hidden');
            }

            if (status === 'disetujui') {
                serahkanForm.action = `/petugas/peminjaman/${id}/serahkan`;
                serahkanForm.classList.remove('hidden');
                rejectButton.classList.remove('hidden');
            }

            const modal = document.getElementById('processModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeProcessModal() {
            const modal = document.getElementById('processModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openRejectModalFromProcess() {
            closeProcessModal();
            openRejectModal(currentId);
        }
    </script>


    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');

            form.action = `/petugas/peminjaman/${id}/reject`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const textarea = document.getElementById('alasan_batal');

            modal.classList.remove('flex');
            modal.classList.add('hidden');
            textarea.value = '';
        }
    </script>
@endsection

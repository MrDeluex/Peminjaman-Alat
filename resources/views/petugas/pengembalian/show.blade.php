@extends('layouts.dashboard')

@section('content')
    <div class="max-w-2xl bg-white rounded-lg shadow p-6">
        <h1 class="text-xl font-bold mb-4">Konfirmasi Pengembalian</h1>

        <div class="space-y-2 text-sm">
            <p><strong>Peminjam:</strong> {{ $peminjaman->user->username }}</p>
            <p><strong>Alat:</strong> {{ $peminjaman->alat->nama_alat }}</p>
            <p><strong>Jumlah Dipinjam:</strong> {{ $peminjaman->jumlah }}</p>
            <p><strong>Hari Telat:</strong> {{ $hariTelat }} hari</p>
            <p><strong>Denda Telat:</strong> Rp {{ number_format($denda, 0, ',', '.') }}</p>
        </div>

        <form action="{{ route('petugas.pengembalian.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

            <!-- Checkbox barang bermasalah -->
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_problem" name="is_problem" value="1" class="rounded">
                <label for="is_problem" class="text-sm">Sebagian barang rusak / hilang</label>
            </div>

            <!-- Field tambahan -->
            <div id="problem-fields" class="hidden space-y-3">
                <div>
                    <label class="block text-sm font-medium">Jumlah rusak / hilang</label>
                    <input type="number" name="jumlah_bermasalah" min="0" max="{{ $peminjaman->jumlah }}"
                        class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: 1">
                    <small class="text-gray-500">
                        Isi 0 jika semua barang kembali normal.
                        Maksimal: {{ $peminjaman->jumlah }}
                    </small>
                </div>
                <div>
                    <label class="block text-sm font-medium">Denda Tambahan</label>
                    <input type="number" name="denda_tambahan" id="denda_tambahan" min="0"
                        class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: 50000">


                </div>
            </div>
            <div>                
                <div class="border rounded p-3 mb-4 bg-gray-50 text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>Denda Telat</span>
                        <span id="preview-denda-telat">
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Denda Tambahan</span>
                        <span id="preview-denda-tambahan">Rp 0</span>
                    </div>

                    <hr>

                    <div class="flex justify-between font-semibold text-base">
                        <span>Total Denda</span>
                        <span id="preview-total-denda">
                            Rp {{ number_format($denda, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('petugas.pengembalian.index') }}" class="px-4 py-2 bg-gray-200 rounded">
                        Batal
                    </a>

                    <button class="px-4 py-2 bg-gray-800 text-white rounded">
                        Selesaikan Pengembalian
                    </button>
                </div>
        </form>
    </div>

    <script>
        const checkbox = document.getElementById('is_problem');
        const fields = document.getElementById('problem-fields');

        checkbox.addEventListener('change', function() {
            fields.classList.toggle('hidden', !this.checked);
        });

        // ===== Preview denda total =====
        const dendaTelat = {{ $denda }}; // dari backend
        const inputDendaTambahan = document.getElementById('denda_tambahan');
        const previewTambahan = document.getElementById('preview-denda-tambahan');
        const previewTotal = document.getElementById('preview-total-denda');

        function formatRupiah(num) {
            return 'Rp ' + (num || 0).toLocaleString('id-ID');
        }

        inputDendaTambahan?.addEventListener('input', function() {
            const tambahan = parseInt(this.value || 0);
            const total = dendaTelat + tambahan;

            previewTambahan.textContent = formatRupiah(tambahan);
            previewTotal.textContent = formatRupiah(total);
        });
    </script>
@endsection

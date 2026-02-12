@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan Alat</h1>
            <p class="text-sm text-gray-500">Informasi lengkap alat dan pengajuan peminjaman</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Informasi Alat</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Alat</p>
                <p class="text-base font-semibold text-gray-800">
                    {{ $alat->nama_alat }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="text-base font-semibold text-gray-800">
                    {{ $alat->kategori->nama_kategori ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Stok Tersedia</p>
                <p class="text-base font-semibold">
                    <span
                        class="px-2 py-1 rounded text-xs
                {{ $alat->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $alat->stok }}
                    </span>
                </p>
            </div>
        </div>


        <div class="border-t p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Form Peminjaman</h2>

            <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
                @csrf

                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Jumlah
                        </label>

                        <input type="number" name="jumlah"
                            {{ $alat->stok == 0 ? 'disabled' : '' }}
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring">

                        @if ($alat->stok == 0)
                            <p class="text-red-500 text-xs mt-1">
                                Stok alat sedang kosong
                            </p>
                        @endif

                        @error('jumlah')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Tanggal Pinjam
                        </label>

                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" min="{{ date('Y-m-d') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring">

                        @error('tanggal_pinjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">
                            Tanggal Kembali Rencana
                        </label>

                        <input type="date" id="tanggal_kembali" name="tanggal_kembali_rencana" min="{{ date('Y-m-d') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring">

                        @error('tanggal_kembali_rencana')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="flex justify-end gap-2">
                    <a href="{{ route('peminjam.alat.index') }}"
                        class="bg-gray-200 px-4 py-2 rounded text-sm hover:bg-gray-300 transition">
                        Kembali
                    </a>
                    <button class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-900 transition">
                        Ajukan Peminjaman
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali');

    tanggalPinjam.addEventListener('change', function () {
        tanggalKembali.min = this.value;

        if (tanggalKembali.value < this.value) {
            tanggalKembali.value = this.value;
        }
    });
</script>


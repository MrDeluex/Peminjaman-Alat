@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan</h1>
    <p class="text-sm text-gray-500">Pilih jenis laporan yang ingin dicetak</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('petugas.laporan.peminjaman') }}" class="bg-white p-5 rounded-lg shadow hover:bg-gray-50 transition">
        <p class="font-semibold">📄 Laporan Peminjaman</p>
        <p class="text-sm text-gray-500">Data seluruh peminjaman</p>
    </a>

    <a href="{{ route('petugas.laporan.pengembalian') }}" class="bg-white p-5 rounded-lg shadow hover:bg-gray-50 transition">
        <p class="font-semibold">🔁 Laporan Pengembalian</p>
        <p class="text-sm text-gray-500">Data pengembalian alat</p>
    </a>

    <a href="{{ route('petugas.laporan.alat') }}" class="bg-white p-5 rounded-lg shadow hover:bg-gray-50 transition">
        <p class="font-semibold">🛠️ Laporan Alat</p>
        <p class="text-sm text-gray-500">Daftar inventaris alat</p>
    </a>
</div>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Alat</h1>
        <p class="text-sm text-gray-500">
            Tambahkan data alat baru ke dalam sistem
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{ route('admin.alat.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Alat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Alat
                </label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" 
                       placeholder="Contoh: Kamera DSLR"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama_alat')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori
                </label>
                <select name="kategori_id" 
                        class="w-full border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stok --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Stok
                </label>
                <input type="number" name="stok" min="0" value="{{ old('stok') }}" 
                       placeholder="0"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('stok')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Denda per Hari --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Denda per Hari
                </label>
                <input type="number" name="harga_denda" min="0" value="{{ old('harga_denda') }}" 
                       placeholder="Contoh: 5000"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('harga_denda')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action --}}
            <div class="flex justify-end items-center gap-3 pt-4">
                <a href="{{ route('admin.alat.index') }}"
                    class="inline-flex items-center px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Kembali
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

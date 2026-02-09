@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Kategori</h1>
        <p class="text-sm text-gray-500">
            Tambahkan kategori baru untuk pengelompokan alat
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kategori
                </label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                       placeholder="Contoh: Buku, Laptop, Barang Elektronik, dll"
                       class="w-full border rounded-lg px-3 py-2 text-sm
                       @error('nama_kategori') border-red-500 @enderror
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama_kategori')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action --}}
            <div class="flex justify-end items-center gap-3 pt-4">
                <a href="{{ route('admin.kategori.index') }}"
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

@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Kategori</h1>
            <p class="text-sm text-gray-500">
                Kelola kategori alat dalam sistem
            </p>
        </div>

        <a href="{{ route('admin.kategori.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
            + Tambah Kategori
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama kategori..."
               class="border rounded-lg px-3 py-2 text-sm">

        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
            Cari
        </button>

        <a href="{{ route('admin.kategori.index') }}"
           class="px-4 py-2 border rounded-lg text-sm text-gray-600">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center w-[60px]">No</th>
                    <th class="px-6 py-3 text-left">Nama Kategori</th>
                    <th class="px-6 py-3 text-center w-[200px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($kategoris as $kategori)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $kategoris->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $kategori->nama_kategori }}
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                               class="inline-block px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                                Edit
                            </a>

                            <button
                                        onclick="openConfirmModal({
                                        url: '{{ route('admin.kategori.destroy', $kategori->id) }}',
                                        method: 'DELETE',
                                        title: 'Hapus Kategori',
                                        message: 'Apakah Anda yakin ingin menghapus Kategori ini?',
                                        confirmText: 'Ya, Hapus',
                                        confirmClass: 'bg-red-600 hover:bg-red-700'
                                    })"
                                        class="px-3 py-1 text-xs rounded bg-red-100 text-red-700 hover:bg-red-200">
                                        Hapus
                                    </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Data kategori tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($kategoris->hasPages())
            <div class="p-4 border-t">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

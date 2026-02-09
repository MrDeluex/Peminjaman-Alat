@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Data Alat</h1>
                <p class="text-sm text-gray-500">
                    Kelola data alat dan stok ketersediaan
                </p>
            </div>

            <a href="{{ route('admin.alat.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                + Tambah Alat
            </a>
        </div>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-4">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat..."
                class="border rounded-lg px-3 py-2 text-sm">

            <select name="kategori" class="border rounded-lg pl-3 pr-8 py-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
                Filter
            </button>

            <a href="{{ route('admin.alat.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600">
                Reset
            </a>

        </form>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-center w-[60px]">No</th>
                        <th class="px-6 py-3 text-left">Nama Alat</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-center w-[80px]">Stok</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($alats as $alat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $alats->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $alat->nama_alat }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($alat->stok > 0)
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">
                                        {{ $alat->stok }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-700">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('admin.alat.edit', $alat->id) }}"
                                    class="inline-block px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                                    Edit
                                </a>

                                <button
                                    onclick="openConfirmModal({
                                        url: '{{ route('admin.alat.destroy', $alat->id) }}',
                                        method: 'DELETE',
                                        title: 'Hapus Alat',
                                        message: 'Apakah Anda yakin ingin menghapus alat ini?',
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
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data alat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($alats->hasPages())
                <div class="p-4 border-t">
                    {{ $alats->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

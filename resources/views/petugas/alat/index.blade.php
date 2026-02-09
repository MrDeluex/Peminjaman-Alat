@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Alat</h1>
            <p class="text-sm text-gray-500">Daftar alat dan stok tersedia</p>
        </div>

        <form method="GET" action="{{ route('petugas.alat.index') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="text-sm text-gray-600">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama Alat"
                    class="border rounded px-3 py-1 text-sm w-52">
            </div>

            <div>
                <label class="text-sm text-gray-600">Kategori</label>
                <select name="kategori_id" class="border rounded pl-2 pr-8 py-1 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-3 py-2 bg-gray-800 text-white rounded text-sm">
                Filter
            </button>

            <a href="{{ route('petugas.alat.index') }}" class="px-3 py-2 bg-gray-200 rounded text-sm">
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
                        <th class="px-4 py-3 text-left">Nama Alat</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($alats as $alat)
                        <tr>
                            <td class="px-4 py-3"> {{ $alats->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">{{ $alat->nama_alat }}</td>
                            <td class="px-4 py-3">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded text-xs
                                    {{ $alat->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $alat->stok }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
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

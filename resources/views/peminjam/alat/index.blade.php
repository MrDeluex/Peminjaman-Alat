@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Alat</h1>
            <p class="text-sm text-gray-500">Daftar seluruh alat yang tersedia untuk dipinjam</p>
        </div>
        <form method="GET" action="{{ route('peminjam.alat.index') }}" class="flex gap-2">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari alat..."
                class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring">

            <select name="kategori" class="border rounded-lg pl-3 pr-8 py-2 text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <button class="bg-gray-800 text-white px-3 py-2 rounded text-sm">
                Cari
            </button>

            <a href="{{ route('peminjam.alat.index') }}" class="bg-gray-200 px-3 py-2 rounded text-sm">
                Reset
            </a>
        </form>

    </div>

    <div class="bg-white rounded-lg shadow">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Alat</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Stok</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($alats as $index => $alat)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $alats->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $alat->nama_alat }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-xs
                            {{ $alat->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $alat->stok }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('peminjam.alat.show', $alat->id) }}"
                                    class="inline-block bg-blue-600 text-white text-xs px-3 py-2 rounded hover:bg-blue-700 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data alat tersedia
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        @if ($alats->hasPages())
            <div class="p-4 border-t">
                {{ $alats->links() }}
            </div>
        @endif

    </div>
@endsection

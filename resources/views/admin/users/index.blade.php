@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Data User</h1>
                <p class="text-sm text-gray-500">
                    Kelola akun dan peran pengguna sistem
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                + Tambah User
            </a>
        </div>

        <form method="GET" class="flex flex-wrap gap-3 mb-4">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username / email"
                class="border rounded-lg px-3 py-2 text-sm">

            <select name="role" class="border rounded-lg pl-3 pr-8 py-2 text-sm">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
            </select>

            <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
                Filter
            </button>

            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600">
                Reset
            </a>

        </form>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-center w-[60px]">No</th>
                        <th class="px-6 py-3 text-left">Username</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $u->username }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium
                            @if ($u->role == 'admin') bg-red-100 text-red-700
                            @elseif($u->role == 'petugas') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                @if ($u->role === 'admin')
                                    <span class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-500 cursor-not-allowed">
                                        Aksi dinonaktifkan
                                    </span>
                                @else
                                    <a href="{{ route('admin.users.edit', $u->id) }}"
                                        class="inline-block px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-700 hover:bg-yellow-200">
                                        Edit Role
                                    </a>

                                    <button
                                        onclick="openConfirmModal({
                                        url: '{{ route('admin.users.destroy', $u->id) }}',
                                        method: 'DELETE',
                                        title: 'Hapus User',
                                        message: 'Apakah Anda yakin ingin menghapus User ini?',
                                        confirmText: 'Ya, Hapus',
                                        confirmClass: 'bg-red-600 hover:bg-red-700'
                                    })"
                                        class="px-3 py-1 text-xs rounded bg-red-100 text-red-700 hover:bg-red-200">
                                        Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($users->hasPages())
                <div class="p-4 border-t">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Tambah User</h1>
        <p class="text-sm text-gray-500">
            Tambahkan akun baru dan tentukan perannya di sistem
        </p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Username
                </label>
                <input
                    type="text"
                    name="username"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="contoh@email.com"
                    required
                >
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Minimal 8 karakter"
                    required
                >
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Role
                </label>
                <select
                    name="role"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                    required
                >
                    <option value="">-- Pilih Role --</option>
                    <option value="petugas">Petugas</option>
                    <option value="peminjam">Peminjam</option>
                </select>
            </div>

            {{-- Action --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900"
                >
                    Simpan User
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

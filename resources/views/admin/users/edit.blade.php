@extends('layouts.dashboard')

@section('content')

@if($user->role === 'admin')
    <div class="alert alert-info">
        Admin utama tidak dapat diubah.
    </div>
@endif
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Role User</h1>
        <p class="text-sm text-gray-500">
            Ubah peran pengguna untuk mengatur hak akses sistem
        </p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-lg shadow p-6">

        <form action="{{ route('admin.users.update', $user->id) }}"
              method="POST"
              class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Username
                </label>
                <input
                    type="text"
                    value="{{ $user->username }}"
                    class="w-full border rounded-lg px-4 py-2 bg-gray-100 text-gray-600 cursor-not-allowed"
                    disabled
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
                    <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>
                        Petugas
                    </option>
                    <option value="peminjam" {{ $user->role=='peminjam'?'selected':'' }}>
                        Peminjam
                    </option>
                </select>
            </div>

            {{-- Action --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900">
                    Update Role
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

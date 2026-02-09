@extends('layouts.dashboard')

@section('title', 'Profile')

@section('header', 'Profile')

@section('content')
    <div class="space-y-6 max-w-5xl">
        <div class="p-6 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Informasi Profil
            </h3>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Ubah Password
            </h3>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow rounded-lg border border-red-100">
            <h3 class="text-lg font-semibold text-red-600 mb-4">
                Hapus Akun
            </h3>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

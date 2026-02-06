@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-2">Selamat Datang</h1>
        <p class="text-gray-600">
            Kamu login sebagai <b>{{ auth()->user()->role }}</b>.
        </p>
    </div>
@endsection

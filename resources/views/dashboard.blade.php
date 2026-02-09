@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    @if(auth()->user()->role === 'admin')
        @include('dashboards.admin')

    @elseif(auth()->user()->role === 'petugas')
        @include('dashboards.petugas')

    @elseif(auth()->user()->role === 'peminjam')
        @include('dashboards.peminjam')

    @endif
@endsection

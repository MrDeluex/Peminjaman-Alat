@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Role User</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control"
                       value="{{ $user->username }}" disabled>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="peminjam" {{ $user->role=='peminjam'?'selected':'' }}>Peminjam</option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection

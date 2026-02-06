@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Log Aktivitas</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->waktu }}</td>
                    <td>{{ $log->user->username }}</td>
                    <td>{{ $log->aktivitas }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

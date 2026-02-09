@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Log Aktivitas</h1>
            <p class="text-sm text-gray-500">
                Riwayat aktivitas pengguna dalam sistem
            </p>
        </div>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari user / aktivitas..."
               class="border rounded-lg px-3 py-2 text-sm">

        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
            Cari
        </button>

        <a href="{{ route('admin.log.index') }}"
           class="px-4 py-2 border rounded-lg text-sm text-gray-600">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center w-[60px]">No</th>
                    <th class="px-6 py-3 text-left w-[180px]">Waktu</th>
                    <th class="px-6 py-3 text-left w-[160px]">User</th>
                    <th class="px-6 py-3 text-left">Aktivitas</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700">
                            {{ $logs->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $log->user->username ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $log->aktivitas }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Data log tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($logs->hasPages())
            <div class="p-4 border-t">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

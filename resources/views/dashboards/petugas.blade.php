@php
    use App\Models\Peminjaman;
    use Carbon\Carbon;

    // Total peminjaman aktif (menunggu + disetujui + dipinjam)
    $peminjamanAktif = Peminjaman::whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])->count();

    // Pengembalian hari ini (yang rencana kembali hari ini)
    $pengembalianHariIni = Peminjaman::whereDate('tanggal_kembali_rencana', Carbon::today())
        ->whereIn('status', ['dipinjam', 'disetujui'])
        ->count();

    // Terlambat = masih dipinjam, tapi lewat tanggal rencana kembali
    $terlambat = Peminjaman::where('status', 'dipinjam')
        ->whereDate('tanggal_kembali_rencana', '<', Carbon::today())
        ->count();

    // Data yang perlu diproses petugas (menunggu + dipinjam)
    $perluDiproses = Peminjaman::with(['user', 'alat'])
        ->whereIn('status', ['menunggu', 'dipinjam'])
        ->latest('tanggal_pinjam')
        ->limit(5)
        ->get();
@endphp



<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
        <p class="text-3xl font-bold text-blue-600">{{ $peminjamanAktif }}</p>
        <p class="text-xs text-gray-400 mt-1">Menunggu, disetujui, dipinjam</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Pengembalian Hari Ini</p>
        <p class="text-3xl font-bold text-green-600">{{ $pengembalianHariIni }}</p>
        <p class="text-xs text-gray-400 mt-1">Jatuh tempo hari ini</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Peminjaman Terlambat</p>
        <p class="text-3xl font-bold text-red-600">{{ $terlambat }}</p>
        <p class="text-xs text-gray-400 mt-1">Lewat jatuh tempo</p>
    </div>
</div>
<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('petugas.peminjaman.index') }}" 
           class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Kelola Peminjaman</p>
            <p class="text-sm text-gray-500">Setujui / tolak peminjaman</p>
        </a>

        <a href="{{ route('petugas.pengembalian.index') }}" 
           class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Kelola Pengembalian</p>
            <p class="text-sm text-gray-500">Konfirmasi alat kembali</p>
        </a>

        <a href="{{ route('petugas.pengembalian.history') }}" 
           class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">History Pengembalian</p>
            <p class="text-sm text-gray-500">Lihat data pengembalian</p>
        </a>
    </div>
</div>
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-lg font-semibold text-gray-900">
            Peminjaman Perlu Diproses
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Peminjam</th>
                    <th class="px-6 py-3 text-left">Alat</th>
                    <th class="px-6 py-3 text-left">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left">Jatuh Tempo</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($perluDiproses as $p)
                    <tr>
                        <td class="px-6 py-4">{{ $p->user->username ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $p->alat->nama_alat ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs
                                @if ($p->status == 'menunggu') bg-gray-100 text-gray-700
                                @elseif($p->status == 'disetujui') bg-blue-100 text-blue-700
                                @elseif($p->status == 'dibatalkan') bg-red-100 text-red-700
                                @elseif($p->status == 'expired') bg-red-100 text-red-700
            @elseif($p->status == 'ditolak') bg-red-100 text-red-700
                                @elseif($p->status == 'dipinjam') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 
                                @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data untuk diproses
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <p class="text-sm text-yellow-800">
        ⚠️ Reminder: Cek pengembalian hari ini untuk mencegah keterlambatan dan selisih stok.
    </p>
</div>

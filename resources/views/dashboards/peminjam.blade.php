@php
    use App\Models\Peminjaman;
    use Carbon\Carbon;

    $userId = auth()->id();

    // Total peminjaman user
    $totalPeminjaman = Peminjaman::where('user_id', $userId)->count();

    // Peminjaman aktif user
    $peminjamanAktif = Peminjaman::where('user_id', $userId)
        ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
        ->count();

    // Peminjaman jatuh tempo hari ini
    $jatuhTempoHariIni = Peminjaman::where('user_id', $userId)
        ->whereDate('tanggal_kembali_rencana', Carbon::today())
        ->where('status', 'dipinjam')
        ->count();

    // Peminjaman terlambat
    $terlambat = Peminjaman::where('user_id', $userId)
        ->where('status', 'dipinjam')
        ->whereDate('tanggal_kembali_rencana', '<', Carbon::today())
        ->count();

    // Riwayat terbaru milik user
    $riwayatTerbaru = Peminjaman::with('alat')->where('user_id', $userId)->latest('tanggal_pinjam')->limit(5)->get();

    $statusLabelsUser = ['menunggu', 'disetujui', 'dipinjam', 'selesai', 'ditolak', 'dibatalkan', 'expired'];

    $statusDataUser = [];
    foreach ($statusLabelsUser as $status) {
        $statusDataUser[] = Peminjaman::where('user_id', $userId)->where('status', $status)->count();
    }

    $monthlyUserData = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
        ->where('user_id', $userId)
        ->whereYear('tanggal_pinjam', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    $bulanLabelsUser = [];
    $bulanDataUser = [];

    for ($i = 1; $i <= 12; $i++) {
        $bulanLabelsUser[] = date('M', mktime(0, 0, 0, $i, 1));
        $bulanDataUser[] = $monthlyUserData[$i] ?? 0;
    }
@endphp

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Peminjam</h1>
        <p class="text-sm text-gray-500">Ringkasan aktivitas peminjaman Anda</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Total Peminjaman</p>
        <p class="text-3xl font-bold text-blue-600">{{ $totalPeminjaman }}</p>
        <p class="text-xs text-gray-400 mt-1">Seluruh riwayat</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
        <p class="text-3xl font-bold text-green-600">{{ $peminjamanAktif }}</p>
        <p class="text-xs text-gray-400 mt-1">Menunggu / dipinjam</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Jatuh Tempo Hari Ini</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $jatuhTempoHariIni }}</p>
        <p class="text-xs text-gray-400 mt-1">Perlu segera dikembalikan</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Terlambat</p>
        <p class="text-3xl font-bold text-red-600">{{ $terlambat }}</p>
        <p class="text-xs text-gray-400 mt-1">Lewat batas waktu</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-6 mt-8">


    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-6">Status Peminjaman Saya</h2>

        <div class="flex flex-col lg:flex-row items-center gap-6">

            <!-- LEGEND -->
            <div class="w-full lg:w-1/2">
                <ul class="space-y-3 text-sm">

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                            <span>Menunggu</span>
                        </div>
                        <span class="font-semibold text-gray-400">{{ $statusDataUser[0] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span>Disetujui</span>
                        </div>
                        <span class="font-semibold text-blue-500">{{ $statusDataUser[1] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span>Dipinjam</span>
                        </div>
                        <span class="font-semibold text-yellow-500">{{ $statusDataUser[2] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span>Selesai</span>
                        </div>
                        <span class="font-semibold text-green-500">{{ $statusDataUser[3] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span>Ditolak</span>
                        </div>
                        <span class="font-semibold text-red-500">{{ $statusDataUser[4] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-300"></span>
                            <span>Dibatalkan</span>
                        </div>
                        <span class="font-semibold text-red-300">{{ $statusDataUser[5] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-700"></span>
                            <span>Expired</span>
                        </div>
                        <span class="font-semibold text-red-700">{{ $statusDataUser[6] }}</span>
                    </li>

                </ul>
            </div>

            <!-- PIE -->
            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="h-56 w-56">
                    <canvas id="userStatusChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Aktivitas Peminjaman</h2>

        <div class="h-64">
            <canvas id="userMonthlyChart"></canvas>
        </div>
    </div>
</div>
<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('peminjam.alat.index') }}" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Cari Alat</p>
            <p class="text-sm text-gray-500">Lihat daftar alat tersedia</p>
        </a>

        <a href="{{ route('peminjam.peminjaman.index') }}" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Peminjaman Saya</p>
            <p class="text-sm text-gray-500">Lihat status peminjaman</p>
        </a>

        <a href="/peminjam/peminjaman?tab=riwayat" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Riwayat Peminjaman</p>
            <p class="text-sm text-gray-500">Lihat riwayat peminjaman</p>
        </a>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-lg font-semibold text-gray-900">
            Aktivitas Terbaru
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Alat</th>
                    <th class="px-6 py-3 text-left">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left">Jatuh Tempo</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($riwayatTerbaru as $p)
                    <tr>
                        <td class="px-6 py-4">{{ $p->alat->nama_alat ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 rounded text-xs
                                @if ($p->status == 'menunggu') bg-gray-100 text-gray-700
                                @elseif($p->status == 'disetujui') bg-blue-100 text-blue-700
                                @elseif($p->status == 'dibatalkan') bg-red-100 text-red-700
            @elseif($p->status == 'ditolak') bg-red-100 text-red-700
            @elseif($p->status == 'expired') bg-red-100 text-red-700
                                @elseif($p->status == 'dipinjam') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($terlambat > 0)
    <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-4">
        <p class="text-sm text-red-800">
            ⚠️ Anda memiliki peminjaman yang terlambat. Harap segera lakukan pengembalian untuk menghindari sanksi.
        </p>
    </div>
@else
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-sm text-blue-800">
            💡 Tips: Selalu periksa tanggal jatuh tempo pada menu <b>Peminjaman Saya</b> agar pengembalian dapat
            dilakukan tepat waktu.
        </p>
    </div>
@endif

<script>
    const userStatusChart = new Chart(document.getElementById('userStatusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabelsUser),
            datasets: [{
                data: @json($statusDataUser),
                backgroundColor: [
                    '#9CA3AF',
                    '#3B82F6',
                    '#F59E0B',
                    '#10B981',
                    '#EF4444',
                    '#F87171',
                    '#DC2626'
                ]
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<script>
    const userMonthlyChart = new Chart(document.getElementById('userMonthlyChart'), {
        type: 'line',
        data: {
            labels: @json($bulanLabelsUser),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($bulanDataUser),
                borderColor: '#3B82F6',
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>

@php
    use App\Models\Alat;
    use App\Models\Peminjaman;
    use App\Models\User;

    $totalAlat = Alat::sum('stok');

    $alatDipinjam = Peminjaman::whereIn('status', ['disetujui', 'dipinjam'])->sum('jumlah');

    $peminjamanAktif = Peminjaman::whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])->count();

    $totalUser = User::count();

    $peminjamanTerbaru = Peminjaman::with(['user', 'alat'])
        ->latest()
        ->limit(5)
        ->get();

    $statusLabels = ['menunggu', 'disetujui', 'dipinjam', 'selesai', 'ditolak', 'dibatalkan', 'expired'];

    $statusData = [];
    foreach ($statusLabels as $status) {
        $statusData[] = Peminjaman::where('status', $status)->count();
    }

    $monthlyData = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
        ->whereYear('tanggal_pinjam', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    $bulanLabels = [];
    $bulanData = [];


    for ($i = 1; $i <= 12; $i++) {
        $bulanLabels[] = date('M', mktime(0, 0, 0, $i, 1));
        $bulanData[] = $monthlyData[$i] ?? 0;
    }
@endphp


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Total Stok Alat</p>
        <p class="text-3xl font-bold text-gray-900">{{ $totalAlat }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Alat Dipinjam</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $alatDipinjam }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
        <p class="text-3xl font-bold text-blue-600"> {{ $peminjamanAktif }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">User Terdaftar</p>
        <p class="text-3xl font-bold text-green-600">{{ $totalUser }}</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-6 mt-8">

    <!-- Grafik Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-6">Status Peminjaman</h2>
        <div class="flex flex-col lg:flex-row items-center gap-6">

            <!-- RIGHT: LEGEND -->
            <div class="w-full lg:w-1/2">
                <ul class="space-y-3 text-sm">

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                            <span>Menunggu</span>
                        </div>
                        <span class="font-semibold text-gray-400">{{ $statusData[0] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span>Disetujui</span>
                        </div>
                        <span class="font-semibold text-blue-500">{{ $statusData[1] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span>Dipinjam</span>
                        </div>
                        <span class="font-semibold text-yellow-500">{{ $statusData[2] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span>Selesai</span>
                        </div>
                        <span class="font-semibold text-green-500">{{ $statusData[3] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span>Ditolak</span>
                        </div>
                        <span class="font-semibold text-red-500">{{ $statusData[4] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-300"></span>
                            <span>Dibatalkan</span>
                        </div>
                        <span class="font-semibold text-red-300">{{ $statusData[5] }}</span>
                    </li>

                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-700"></span>
                            <span>Expired</span>
                        </div>
                        <span class="font-semibold text-red-700">{{ $statusData[6] }}</span>
                    </li>

                </ul>
            </div>

            <!-- LEFT: PIE CHART -->
            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="h-56 w-56">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>


        </div>
    </div>

    <!-- Grafik Bulanan -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Peminjaman per Bulan</h2>
        <div class="h-72">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>

<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.alat.index') }}" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Kelola Alat</p>
            <p class="text-sm text-gray-500">Tambah, edit, hapus data alat</p>
        </a>

        <a href="{{ route('admin.peminjaman.index') }}" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Data Peminjaman</p>
            <p class="text-sm text-gray-500">Lihat peminjaman aktif</p>
        </a>

        <a href="{{ route('admin.users.index') }}" class="border rounded-lg p-4 hover:bg-gray-50 transition">
            <p class="font-semibold text-gray-900">Kelola User</p>
            <p class="text-sm text-gray-500">Admin, petugas, peminjam</p>
        </a>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h2 class="text-lg font-semibold text-gray-900">
            Peminjaman Terbaru
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Peminjam</th>
                    <th class="px-6 py-3 text-left">Alat</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($peminjamanTerbaru as $p)
                    <tr>
                        <td class="px-6 py-4">{{ $p->user->username }}</td>
                        <td class="px-6 py-4">{{ $p->alat->nama_alat }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 rounded text-xs
            @if ($p->status == 'menunggu') bg-gray-100 text-gray-700
            @elseif($p->status == 'disetujui') bg-blue-100 text-blue-700
            @elseif($p->status == 'dibatalkan') bg-red-100 text-red-700
            @elseif($p->status == 'expired') bg-red-100 text-red-700
            @elseif($p->status == 'ditolak') bg-red-100 text-red-700
            @elseif($p->status == 'dipinjam') bg-yellow-100 text-yellow-700
            @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <p class="text-sm text-blue-800">
        💡 Tips: Pastikan data pengembalian diperbarui setiap hari untuk menjaga akurasi stok alat.
    </p>
</div>

<script>
    // STATUS CHART (PIE)
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusData),
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

    // MONTHLY CHART (LINE)
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($bulanData),
                borderColor: '#3B82F6',
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil peminjaman dengan status selesai & dipinjam
        $peminjamans = DB::table('peminjamans')
            ->whereIn('status', ['selesai', 'dipinjam'])
            ->get();

        $data = [];

        foreach ($peminjamans as $p) {

            // Default tanggal kembali
            $tanggalKembali = Carbon::parse($p->tanggal_kembali_rencana);

            $dendaTelat = 0;
            $dendaTambahan = 0;

            if ($p->status === 'selesai') {
                // Simulasi: ada yang telat 1-3 hari
                $telatHari = rand(0, 3);

                $tanggalKembali = $tanggalKembali->copy()->addDays($telatHari);

                $alat = DB::table('alats')->where('id', $p->alat_id)->first();
                $dendaTelat = $telatHari * $alat->harga_denda;

                // kemungkinan denda tambahan (kerusakan)
                $dendaTambahan = rand(0, 1) ? rand(10000, 30000) : 0;
            }

            if ($p->status === 'dipinjam') {
                // Belum dikembalikan → tanggal hari ini
                $tanggalKembali = Carbon::now();

                // belum ada denda
                $dendaTelat = 0;
                $dendaTambahan = 0;
            }

            $totalDenda = $dendaTelat + $dendaTambahan;

            $data[] = [
                'peminjaman_id' => $p->id,
                'tanggal_pengembalian' => $tanggalKembali->toDateString(),
                'denda' => $totalDenda,
                'denda_telat' => $dendaTelat,
                'denda_tambahan' => $dendaTambahan,
                'total_denda' => $totalDenda,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pengembalians')->insert($data);
    }
}

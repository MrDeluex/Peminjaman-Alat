<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->get();
        $alats = DB::table('alats')->get();

        if ($users->isEmpty() || $alats->isEmpty()) {
            return;
        }

        DB::table('peminjamans')->insert([

            // MENUNGGU
            [
                'user_id' => $users[2]->id, // peminjam
                'alat_id' => $alats[0]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(3)->toDateString(),
                'status' => 'menunggu',
                'keterangan' => 'Menunggu persetujuan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DISETUJUI
            [
                'user_id' => $users[2]->id,
                'alat_id' => $alats[1]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(1)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(2)->toDateString(),
                'status' => 'disetujui',
                'keterangan' => 'Sudah disetujui petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIPINJAM
            [
                'user_id' => $users[3]->id,
                'alat_id' => $alats[2]->id,
                'jumlah' => 2,
                'tanggal_pinjam' => Carbon::now()->subDays(2)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(1)->toDateString(),
                'status' => 'dipinjam',
                'keterangan' => 'Sedang dipinjam',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DITOLAK
            [
                'user_id' => $users[2]->id,
                'alat_id' => $alats[3]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(3)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(1)->toDateString(),
                'status' => 'ditolak',
                'keterangan' => 'Stok tidak mencukupi',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DIBATALKAN
            [
                'user_id' => $users[3]->id,
                'alat_id' => $alats[4]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(4)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(2)->toDateString(),
                'status' => 'dibatalkan',
                'keterangan' => 'Dibatalkan oleh peminjam',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // EXPIRED
            [
                'user_id' => $users[2]->id,
                'alat_id' => $alats[5]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(5)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(1)->toDateString(),
                'status' => 'expired',
                'keterangan' => 'Tidak diambil hingga batas waktu',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // SELESAI
            [
                'user_id' => $users[3]->id,
                'alat_id' => $alats[6]->id,
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(7)->toDateString(),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(3)->toDateString(),
                'status' => 'selesai',
                'keterangan' => 'Peminjaman telah selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
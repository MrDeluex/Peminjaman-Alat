<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoExpirePeminjaman extends Command
{
    protected $signature = 'peminjaman:auto-expire';
    protected $description = 'Auto expire peminjaman menunggu & disetujui yang melewati tanggal pinjam (no-show)';

    public function handle()
    {
        $today = Carbon::today();

        $countMenunggu = Peminjaman::where('status', Peminjaman::STATUS_MENUNGGU)
            ->whereDate('tanggal_pinjam', '<', $today)
            ->update([
                'status' => Peminjaman::STATUS_EXPIRED,
                'keterangan' => 'Expired otomatis: tidak diproses sampai tanggal pinjam',
            ]);

        $countDisetujui = Peminjaman::where('status', Peminjaman::STATUS_DISETUJUI)
            ->whereDate('tanggal_pinjam', '<', $today)
            ->update([
                'status' => Peminjaman::STATUS_EXPIRED,
                'keterangan' => 'Expired otomatis: peminjam tidak datang mengambil alat (no-show)',
            ]);

        $total = $countMenunggu + $countDisetujui;

        $this->info("{$total} peminjaman berhasil di-expire (menunggu: {$countMenunggu}, disetujui/no-show: {$countDisetujui}).");
    }
}

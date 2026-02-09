<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'dipinjam',
                'ditolak',
                'dibatalkan',
                'expired',
                'selesai'
            ) NOT NULL DEFAULT 'menunggu'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjamans 
            MODIFY status ENUM(
                'menunggu',
                'disetujui',
                'dipinjam',
                'ditolak',
                'dibatalkan',
                'selesai'
            ) NOT NULL DEFAULT 'menunggu'
        ");
    }
};

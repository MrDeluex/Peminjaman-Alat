<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->integer('denda_telat')->default(0)->after('tanggal_pengembalian');
            $table->integer('denda_tambahan')->nullable()->after('denda_telat');
            $table->integer('total_denda')->default(0)->after('denda_tambahan');

            // opsional: keep kolom lama denda dulu biar gak error data lama
            // nanti bisa di-drop kalau sudah migrasi penuh
        });
    }

    public function down(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropColumn(['denda_telat', 'denda_tambahan', 'total_denda']);
        });
    }
};

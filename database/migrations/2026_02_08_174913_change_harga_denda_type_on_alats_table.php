<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_denda')->change();
        });
    }

    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            $table->integer('harga_denda')->change();
        });
    }
};


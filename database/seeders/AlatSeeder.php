<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriLaptop = DB::table('kategoris')->where('nama_kategori', 'Laptop')->first();
        $kategoriKamera = DB::table('kategoris')->where('nama_kategori', 'Kamera')->first();
        $kategoriLensa  = DB::table('kategoris')->where('nama_kategori', 'Lensa')->first();

        DB::table('alats')->insert([

            // LAPTOP (denda: 10.000/hari)
            [
                'nama_alat' => 'Laptop Asus VivoBook',
                'kategori_id' => $kategoriLaptop->id,
                'stok' => 5,
                'harga_denda' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Laptop Acer Aspire 5',
                'kategori_id' => $kategoriLaptop->id,
                'stok' => 4,
                'harga_denda' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Laptop Lenovo IdeaPad',
                'kategori_id' => $kategoriLaptop->id,
                'stok' => 6,
                'harga_denda' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KAMERA (denda: 15.000/hari)
            [
                'nama_alat' => 'Canon EOS 1500D',
                'kategori_id' => $kategoriKamera->id,
                'stok' => 3,
                'harga_denda' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Nikon D3500',
                'kategori_id' => $kategoriKamera->id,
                'stok' => 2,
                'harga_denda' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Sony Alpha A6000',
                'kategori_id' => $kategoriKamera->id,
                'stok' => 3,
                'harga_denda' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // LENSA (denda: 8.000/hari)
            [
                'nama_alat' => 'Canon 50mm f/1.8',
                'kategori_id' => $kategoriLensa->id,
                'stok' => 5,
                'harga_denda' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Nikon 35mm f/1.8',
                'kategori_id' => $kategoriLensa->id,
                'stok' => 4,
                'harga_denda' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_alat' => 'Sony 24-70mm f/2.8',
                'kategori_id' => $kategoriLensa->id,
                'stok' => 2,
                'harga_denda' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
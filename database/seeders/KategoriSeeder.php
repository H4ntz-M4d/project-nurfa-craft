<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_produk')->insert([
            [
                'id_ktg_produk' => 1,
                'nama_kategori' => 'Tas',
                'deskripsi' => 'Berbagai jenis tas fashion dan fungsional.',
                'status' => 'published',
                'meta_keywords' => 'tas, fashion, aksesoris',
                'meta_desc' => 'Kategori produk tas terbaik untuk semua kebutuhan.',
                'gambar' => 'tas.jpg',
                'slug' => 'tas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ktg_produk' => 2,
                'nama_kategori' => 'Topi',
                'deskripsi' => 'Aneka topi gaya dan pelindung kepala.',
                'status' => 'published',
                'meta_keywords' => 'topi, gaya, aksesoris',
                'meta_desc' => 'Kategori produk topi modis dan klasik.',
                'gambar' => 'topi.jpg',
                'slug' => 'topi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ktg_produk' => 3,
                'nama_kategori' => 'Syal',
                'deskripsi' => 'Koleksi syal untuk kehangatan dan gaya.',
                'status' => 'published',
                'meta_keywords' => 'syal, hangat, mode',
                'meta_desc' => 'Kategori produk syal untuk berbagai suasana.',
                'gambar' => 'syal.jpg',
                'slug' => 'syal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

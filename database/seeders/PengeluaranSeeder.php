<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data untuk tabel pengeluaran
        $pengeluaran = [
            [
                'id_pengeluaran' => 1,
                'kategori_pengeluaran' => 'Bahan Baku',
                'nama_pengeluaran' => 'Benang Rajut Katun',
                'jumlah_pengeluaran' => 1500000.00,
                'tanggal_pengeluaran' => '2025-01-10',
                'keterangan' => 'Pembelian benang rajut katun',
                'slug' => 'pengeluaran-benang-jan2025',
                'id_user' => 1,
                'created_at' => '2025-01-10 00:00:00',
                'updated_at' => '2025-01-10 00:00:00',
            ],
            [
                'id_pengeluaran' => 2,
                'kategori_pengeluaran' => 'Alat Produksi',
                'nama_pengeluaran' => 'Hakpen Aluminium',
                'jumlah_pengeluaran' => 300000.00,
                'tanggal_pengeluaran' => '2025-02-12',
                'keterangan' => 'Pembelian hakpen baru',
                'slug' => 'pengeluaran-hakpen-feb2025',
                'id_user' => 1,
                'created_at' => '2025-02-12 00:00:00',
                'updated_at' => '2025-02-12 00:00:00',
            ],
            [
                'id_pengeluaran' => 3,
                'kategori_pengeluaran' => 'Bahan Baku',
                'nama_pengeluaran' => 'Benang Rajut Premium',
                'jumlah_pengeluaran' => 2000000.00,
                'tanggal_pengeluaran' => '2025-03-05',
                'keterangan' => 'Stok benang premium untuk pesanan besar',
                'slug' => 'pengeluaran-benang-mar2025',
                'id_user' => 1,
                'created_at' => '2025-03-05 00:00:00',
                'updated_at' => '2025-03-05 00:00:00',
            ],
            [
                'id_pengeluaran' => 4,
                'kategori_pengeluaran' => 'Operasional',
                'nama_pengeluaran' => 'Biaya Listrik dan Air',
                'jumlah_pengeluaran' => 750000.00,
                'tanggal_pengeluaran' => '2025-04-01',
                'keterangan' => 'Pembayaran listrik & air bulan Maret',
                'slug' => 'pengeluaran-operasional-apr2025',
                'id_user' => 1,
                'created_at' => '2025-04-01 00:00:00',
                'updated_at' => '2025-04-01 00:00:00',
            ],
            [
                'id_pengeluaran' => 5,
                'kategori_pengeluaran' => 'Promosi',
                'nama_pengeluaran' => 'Cetak Brosur & Katalog',
                'jumlah_pengeluaran' => 500000.00,
                'tanggal_pengeluaran' => '2025-05-15',
                'keterangan' => 'Promosi produk rajut handmade',
                'slug' => 'pengeluaran-promosi-mei2025',
                'id_user' => 1,
                'created_at' => '2025-05-15 00:00:00',
                'updated_at' => '2025-05-15 00:00:00',
            ],
            [
                'id_pengeluaran' => 6,
                'kategori_pengeluaran' => 'Bahan Baku',
                'nama_pengeluaran' => 'Benang Rajut Polos',
                'jumlah_pengeluaran' => 1750000.00,
                'tanggal_pengeluaran' => '2025-06-18',
                'keterangan' => 'Pembelian benang polos untuk stok',
                'slug' => 'pengeluaran-benang-jun2025',
                'id_user' => 1,
                'created_at' => '2025-06-18 00:00:00',
                'updated_at' => '2025-06-18 00:00:00',
            ],
            [
                'id_pengeluaran' => 7,
                'kategori_pengeluaran' => 'Pengiriman',
                'nama_pengeluaran' => 'Ongkir Supplier Bahan',
                'jumlah_pengeluaran' => 600000.00,
                'tanggal_pengeluaran' => '2025-07-08',
                'keterangan' => 'Ongkir bahan baku dari Bandung',
                'slug' => 'pengeluaran-ongkir-jul2025',
                'id_user' => 1,
                'created_at' => '2025-07-08 00:00:00',
                'updated_at' => '2025-07-08 00:00:00',
            ],
        ];

        // Truncate table untuk menghindari duplikasi data
        DB::table('pengeluaran')->truncate();

        // Insert data ke tabel pengeluaran
        DB::table('pengeluaran')->insert($pengeluaran);

        $this->command->info('Data pengeluaran berhasil ditambahkan!');
    }
}
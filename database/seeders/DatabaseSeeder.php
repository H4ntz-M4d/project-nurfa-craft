<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Database\Seeders\UsersSeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ProdukSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\TransactionDetailsSeeder;
use Database\Seeders\PesananSeeder;
use Database\Seeders\PengeluaranSeeder;
use Database\Seeders\KategoriSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'slug' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('karyawan')->insert([
            'id_karyawan' => '1',
            'id_user' => '1',
            'nama' => 'Super Admin',
            'jkel' => 'pria',
            'no_telp' => '08983689868',
            'alamat' => '-',
            'tempat_lahir' => '-',
            'tgl_lahir' => now(),
            'slug' => Hash::make('super admin nurfa'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call([
            UsersSeeder::class,
            CustomersSeeder::class,
            KategoriSeeder::class, 
            ProdukSeeder::class,
            TransactionSeeder::class,
            TransactionDetailsSeeder::class,
            PesananSeeder::class,
            PengeluaranSeeder::class,
        ]);
    }
}

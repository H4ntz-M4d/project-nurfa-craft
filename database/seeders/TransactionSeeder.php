<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $transactions = [];
        
        // Generate 103 transactions distributed across 7 months (Jan-Jul 2025)
        for ($i = 1; $i <= 103; $i++) {
            // Distribute transactions across months (Jan-Jul)
            $month = $this->getMonthForTransaction($i);
            
            // Distribute days evenly within the month (max 28 to be safe)
            $day = ($i % 28) + 1;
            
            // Distribute hours throughout the day
            $hour = $i % 24;
            $minute = $i % 60;
            $second = ($i * 2) % 60;
            
            $transactions[] = [
                'id_transaction' => $i,
                'telepon' => '08123456789',
                'slug' => 'order-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'order_id' => 'ORD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'snap_token' => 'token-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'id_user' => ($i % 50) + 1, // Cycle through users 1-50
                'tanggal' => sprintf('2025-%02d-%02d %02d:%02d:%02d', $month, $day, $hour, $minute, $second),
                'total' => 1000000 + ($i * 12345.67),
                'status' => 'paid',
                'provinsi' => 'Provinsi-' . $i,
                'kota' => 'Kota-' . $i,
                'alamat_pengiriman' => 'Alamat-' . $i,
                'created_at' => '2025-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . ' ' . sprintf('%02d:%02d:%02d', $hour, $minute, $second),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }
    
    protected function getMonthForTransaction($index)
    {
        // Distribute 103 transactions across 7 months (Jan-Jul)
        // This creates roughly 15 transactions per month
        if ($index <= 15) return 1;    // January
        if ($index <= 30) return 2;    // February
        if ($index <= 45) return 3;    // March
        if ($index <= 60) return 4;    // April
        if ($index <= 75) return 5;    // May
        if ($index <= 90) return 6;    // June
        return 7;                      // July
    }
}
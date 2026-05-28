<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Purchase::insert([
            [
                'performance_id' => 12,
                'user_id' => 11,
                'ticket_amount' => 2,
                'total_amount' => 20000,
                'payment_status' => 'approved',
                'payment_gateway_id' => 'MP-1001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'performance_id' => 12,
                'user_id' => 3,
                'ticket_amount' => 4,
                'total_amount' => 60,
                'payment_status' => 'pending',
                'payment_gateway_id' => 'MP-1002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'performance_id' => 19,
                'user_id' => 12,
                'ticket_amount' => 1,
                'total_amount' => 15,
                'payment_status' => 'approved',
                'payment_gateway_id' => 'MP-1003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'performance_id' => 1,
                'user_id' => 8,
                'ticket_amount' => 3,
                'total_amount' => 45000,
                'payment_status' => 'rejected',
                'payment_gateway_id' => 'MP-1004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'performance_id' => 14,
                'user_id' => 8,
                'ticket_amount' => 2,
                'total_amount' => 30,
                'payment_status' => 'approved',
                'payment_gateway_id' => 'MP-1005',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
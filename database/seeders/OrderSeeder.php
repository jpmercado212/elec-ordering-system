<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::value('id') ?? User::factory()->create()->id;

        Order::insert([
            [
                'user_id'      => $userId,
                'order_date'   => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                'total_price'  => 1499.00,
                'order_status' => 'pending',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => $userId,
                'order_date'   => Carbon::now()->subDay()->format('Y-m-d H:i:s'),
                'total_price'  => 2599.50,
                'order_status' => 'processing',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => $userId,
                'order_date'   => Carbon::now()->format('Y-m-d H:i:s'),
                'total_price'  => 999.00,
                'order_status' => 'completed',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
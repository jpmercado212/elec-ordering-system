<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing inventory to avoid duplicates
        DB::table('inventory')->truncate();

        $products = Product::all();
        $inventoryRows = [];
        $now = now();
        
        foreach ($products as $product) {
            // Generate realistic stock quantities between 10-100
            $randomStock = rand(10, 100);
            
            $inventoryRows[] = [
                'product_id' => $product->product_id,
                'quantity_in_stock' => $randomStock,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        if (!empty($inventoryRows)) {
            DB::table('inventory')->insert($inventoryRows);
            $this->command->info('Inventory seeded with ' . count($inventoryRows) . ' records.');
        } else {
            $this->command->info('No products found to seed inventory.');
        }
    }
}

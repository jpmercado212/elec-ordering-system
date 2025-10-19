<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            // WOMEN
            [
                'product_name' => 'Floral Summer Dress',
                'description' => 'Lightweight chiffon dress perfect for summer outings.',
                'price' => 899.00,
                'available_quantity' => 40,
                'category' => 'Women',
                'image' => 'floral_dress.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'High-Waisted Skinny Jeans',
                'description' => 'Comfortable stretch denim that flatters every body type.',
                'price' => 1199.00,
                'available_quantity' => 50,
                'category' => 'Women',
                'image' => 'skinny_jeans.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // MEN
            [
                'product_name' => 'Classic White Polo Shirt',
                'description' => 'Breathable cotton polo perfect for casual and semi-formal wear.',
                'price' => 699.00,
                'available_quantity' => 60,
                'category' => 'Men',
                'image' => 'white_polo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Slim Fit Denim Jacket',
                'description' => 'Stylish light-wash denim jacket with button closures.',
                'price' => 1499.00,
                'available_quantity' => 30,
                'category' => 'Men',
                'image' => 'denim_jacket.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KIDS
            [
                'product_name' => 'Kids Graphic T-Shirt',
                'description' => '100% cotton tee with fun cartoon print.',
                'price' => 399.00,
                'available_quantity' => 80,
                'category' => 'Kids',
                'image' => 'kids_tshirt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Girls Denim Skirt',
                'description' => 'Soft denim skirt with elastic waistband for comfort.',
                'price' => 499.00,
                'available_quantity' => 45,
                'category' => 'Kids',
                'image' => 'girls_skirt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // BABY
            [
                'product_name' => 'Baby Onesie Set (3pcs)',
                'description' => 'Soft organic cotton onesies in neutral colors.',
                'price' => 699.00,
                'available_quantity' => 35,
                'category' => 'Baby',
                'image' => 'baby_onesie.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Baby Booties',
                'description' => 'Cozy knitted booties to keep little feet warm.',
                'price' => 299.00,
                'available_quantity' => 55,
                'category' => 'Baby',
                'image' => 'baby_booties.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // SHOES
            [
                'product_name' => 'White Canvas Sneakers',
                'description' => 'Classic low-top sneakers with rubber soles.',
                'price' => 1299.00,
                'available_quantity' => 40,
                'category' => 'Shoes',
                'image' => 'canvas_sneakers.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Black Leather Loafers',
                'description' => 'Elegant loafers suitable for both office and casual wear.',
                'price' => 1999.00,
                'available_quantity' => 25,
                'category' => 'Shoes',
                'image' => 'leather_loafers.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // BAGS
            [
                'product_name' => 'Mini Crossbody Bag',
                'description' => 'Compact faux-leather bag with adjustable strap.',
                'price' => 899.00,
                'available_quantity' => 30,
                'category' => 'Bags',
                'image' => 'crossbody_bag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Tote Bag with Zipper',
                'description' => 'Spacious canvas tote for daily essentials.',
                'price' => 699.00,
                'available_quantity' => 45,
                'category' => 'Bags',
                'image' => 'tote_bag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ACCESSORIES
            [
                'product_name' => 'Gold Hoop Earrings',
                'description' => 'Elegant and lightweight earrings with a smooth finish.',
                'price' => 299.00,
                'available_quantity' => 100,
                'category' => 'Accessories',
                'image' => 'hoop_earrings.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Unisex Sunglasses',
                'description' => 'UV-protected sunglasses with a modern frame design.',
                'price' => 499.00,
                'available_quantity' => 60,
                'category' => 'Accessories',
                'image' => 'sunglasses.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Nike Air Max 270',
                'description' => 'The Nike Air Max 270 features a sleek design with maximum comfort. Perfect for everyday wear with superior cushioning and breathability.',
                'price' => 149.99,
                'category' => 'Running',
                'stock' => 50,
            ],
            [
                'name' => 'Adidas Ultra Boost',
                'description' => 'Experience ultimate energy return with the Adidas Ultra Boost. Primeknit upper provides adaptive support and ultralight comfort.',
                'price' => 179.99,
                'category' => 'Running',
                'stock' => 45,
            ],
            [
                'name' => 'Puma RS-X',
                'description' => 'Bold and retro-inspired design meets modern comfort. The Puma RS-X brings back the 80s vibe with contemporary styling.',
                'price' => 109.99,
                'category' => 'Casual',
                'stock' => 60,
            ],
            [
                'name' => 'New Balance 574',
                'description' => 'Classic comfort meets timeless style. The New Balance 574 is an iconic sneaker with a premium suede and mesh upper.',
                'price' => 84.99,
                'category' => 'Casual',
                'stock' => 70,
            ],
            [
                'name' => 'Converse Chuck Taylor All Star',
                'description' => 'The original basketball shoe that became a cultural icon. Timeless canvas design that never goes out of style.',
                'price' => 64.99,
                'category' => 'Casual',
                'stock' => 100,
            ],
            [
                'name' => 'Vans Old Skool',
                'description' => 'A skate classic with the iconic sidestripe. Durable canvas and suede upper with signature waffle outsole.',
                'price' => 69.99,
                'category' => 'Skateboard',
                'stock' => 80,
            ],
            [
                'name' => 'Jordan 1 Retro High',
                'description' => 'The legendary silhouette that started it all. Premium leather construction with Nike Air cushioning.',
                'price' => 189.99,
                'category' => 'Basketball',
                'stock' => 30,
            ],
            [
                'name' => 'Reebok Classic Leather',
                'description' => 'Simple, clean, and timeless. Soft garment leather upper with die-cut EVA midsole for lightweight cushioning.',
                'price' => 79.99,
                'category' => 'Casual',
                'stock' => 55,
            ],
            [
                'name' => 'ASICS Gel-Kayano 28',
                'description' => 'Premium stability running shoe with advanced GEL technology. Engineered for overpronators seeking maximum support.',
                'price' => 159.99,
                'category' => 'Running',
                'stock' => 40,
            ],
            [
                'name' => 'Skechers Go Walk 6',
                'description' => 'Ultra-lightweight and responsive walking shoe. Air-cooled Goga Mat insole provides enhanced comfort.',
                'price' => 89.99,
                'category' => 'Walking',
                'stock' => 65,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

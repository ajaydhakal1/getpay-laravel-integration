<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Ceramic Mug Set', 'price' => 450, 'image' => 'https://plus.unsplash.com/premium_photo-1678495222603-b66f6393c166?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwxfHx8ZW58MHx8fHx8'],
            ['name' => 'Leather Notebook', 'price' => 550, 'image' => 'https://images.unsplash.com/photo-1741125671743-4e4624fbb9ed?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHx0b3BpYy1mZWVkfDUxfEpwZzZLaWRsLUhrfHxlbnwwfHx8fHw%3D'],
            ['name' => 'Premium Pen Pack', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1743094471462-8d90a8b9459e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHx0b3BpYy1mZWVkfDE2fEpwZzZLaWRsLUhrfHxlbnwwfHx8fHw%3D'],
            ['name' => 'Stainless Steel Bottle', 'price' => 600, 'image' => 'https://images.unsplash.com/photo-1742038107091-9a7e1f01b42c?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwzM3x8fGVufDB8fHx8fA%3D%3D'],
            ['name' => 'Eco Tote Bag', 'price' => 250, 'image' => 'https://images.unsplash.com/photo-1743090834072-4f70339bc917?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwxOXx8fGVufDB8fHx8fA%3D%3D'],
            ['name' => 'Desk Organizer', 'price' => 720, 'image' => 'https://images.unsplash.com/photo-1736344319749-93bc29f03d5d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxmZWF0dXJlZC1waG90b3MtZmVlZHwyMnx8fGVufDB8fHx8fA%3D%3D'],
        ];

        DB::table('products')->insert($products);
    }
}

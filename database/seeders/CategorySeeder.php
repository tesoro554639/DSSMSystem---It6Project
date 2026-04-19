<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tops', 'description' => 'Shirts, blouses, and tops'],
            ['name' => 'Bottoms', 'description' => 'Pants, shorts, skirts'],
            ['name' => 'Dresses', 'description' => 'Dresses and jumpsuits'],
            ['name' => 'Outerwear', 'description' => 'Jackets, coats, and cardigans'],
            ['name' => 'Accessories', 'description' => 'Bags, belts, hats, and scarves'],
            ['name' => 'Footwear', 'description' => 'Shoes and sandals'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
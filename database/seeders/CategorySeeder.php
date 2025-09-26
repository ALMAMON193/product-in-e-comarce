<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Devices, gadgets, and accessories',
                'image' => 'https://via.placeholder.com/150?text=Electronics',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, and accessories',
                'image' => 'https://via.placeholder.com/150?text=Fashion',
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Furniture, appliances, and decor',
                'image' => 'https://via.placeholder.com/150?text=Home+%26+Kitchen',
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Skincare, haircare, cosmetics',
                'image' => 'https://via.placeholder.com/150?text=Beauty',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment, outdoor gear',
                'image' => 'https://via.placeholder.com/150?text=Sports',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Kids toys and games',
                'image' => 'https://via.placeholder.com/150?text=Toys',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car accessories and parts',
                'image' => 'https://via.placeholder.com/150?text=Automotive',
            ],
            [
                'name' => 'Books & Stationery',
                'description' => 'Books, office supplies, stationery',
                'image' => 'https://via.placeholder.com/150?text=Books',
            ],
            [
                'name' => 'Health & Wellness',
                'description' => 'Supplements, fitness products',
                'image' => 'https://via.placeholder.com/150?text=Health',
            ],
            [
                'name' => 'Pet Supplies',
                'description' => 'Pet food, toys, and accessories',
                'image' => 'https://via.placeholder.com/150?text=Pets',
            ],
        ];

        foreach ($categories as $index => $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'image' => $cat['image'],
                'is_featured' => $index % 2 === 0,
                'sort_order' => $index + 1,
                'status' => 'active',
            ]);
        }
    }
}

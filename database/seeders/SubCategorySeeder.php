<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Cameras', 'Headphones', 'Smart Watches'],
            'Fashion' => ['Men Clothing', 'Women Clothing', 'Shoes', 'Bags', 'Accessories'],
            'Home & Kitchen' => ['Furniture', 'Kitchen Appliances', 'Bedding', 'Home Decor', 'Lighting'],
            'Beauty & Personal Care' => ['Skincare', 'Haircare', 'Makeup', 'Fragrances', 'Personal Care'],
            'Sports & Outdoors' => ['Fitness Equipment', 'Outdoor Gear', 'Cycling', 'Camping', 'Sportswear'],
            'Toys & Games' => ['Action Figures', 'Puzzles', 'Board Games', 'Educational Toys', 'Outdoor Toys'],
            'Automotive' => ['Car Accessories', 'Motorbike Accessories', 'Tools', 'Car Care', 'Tires & Wheels'],
            'Books & Stationery' => ['Fiction', 'Non-Fiction', 'Educational', 'Office Supplies', 'Art & Craft'],
            'Health & Wellness' => ['Supplements', 'Fitness Products', 'Medical Supplies', 'Yoga & Meditation', 'Nutrition'],
            'Pet Supplies' => ['Pet Food', 'Toys', 'Pet Care', 'Beds & Accessories', 'Training'],
        ];

        foreach ($subCategories as $categoryName => $subs) {
            $category = Category::where('name', $categoryName)->first();
            if (! $category) {
                continue;
            }

            foreach ($subs as $index => $subName) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'description' => 'Shop '.$subName.' in '.$categoryName,
                    'image' => 'https://via.placeholder.com/100?text='.urlencode($subName),
                    'is_featured' => $index % 2 === 0,
                    'sort_order' => $index + 1,
                    'status' => 'active',
                ]);
            }
        }
    }
}

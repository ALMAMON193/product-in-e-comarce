<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductFile;
use App\Models\ProductPricing;
use App\Models\ProductSubCategory;
use App\Models\ProductTag;
use App\Models\SubCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define 10 categories with sample names
        $categories = [
            'Electronics', 'Clothing', 'Home & Kitchen', 'Books', 'Sports',
            'Beauty', 'Toys & Games', 'Automotive', 'Health', 'Jewelry',
        ];

        // Define subcategories for each category (5 per category)
        $subcategories = [
            'Electronics' => ['Smartphones', 'Laptops', 'Headphones', 'Cameras', 'Accessories'],
            'Clothing' => ['Men\'s Wear', 'Women\'s Wear', 'Kids\' Wear', 'Footwear', 'Accessories'],
            'Home & Kitchen' => ['Furniture', 'Appliances', 'Decor', 'Cookware', 'Bedding'],
            'Books' => ['Fiction', 'Non-Fiction', 'Textbooks', 'Comics', 'Magazines'],
            'Sports' => ['Fitness Equipment', 'Outdoor Gear', 'Sportswear', 'Bicycles', 'Accessories'],
            'Beauty' => ['Skincare', 'Makeup', 'Haircare', 'Fragrances', 'Personal Care'],
            'Toys & Games' => ['Action Figures', 'Board Games', 'Puzzles', 'Dolls', 'Educational Toys'],
            'Automotive' => ['Car Accessories', 'Motorcycle Parts', 'Tools', 'Tires', 'Electronics'],
            'Health' => ['Supplements', 'Medical Devices', 'Personal Care', 'Fitness Trackers', 'Wellness'],
            'Jewelry' => ['Necklaces', 'Rings', 'Bracelets', 'Earrings', 'Watches'],
        ];

        // Create Categories
        foreach ($categories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => $faker->paragraph,
                'image' => 'img/img-'.$faker->numberBetween(1, 10).'.png',
                'is_featured' => $faker->boolean(20),
                'status' => 'active',
                'sort_order' => $faker->numberBetween(0, 100),
            ]);

            // Create Subcategories for each Category
            foreach ($subcategories[$categoryName] as $subCategoryName) {
                $subCategory = SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subCategoryName,
                    'slug' => Str::slug($subCategoryName),
                    'description' => $faker->paragraph,
                    'image' => 'img/img-'.$faker->numberBetween(1, 10).'.png',
                    'is_featured' => $faker->boolean(20),
                    'status' => 'active',
                    'sort_order' => $faker->numberBetween(0, 100),
                ]);
                $productName = ucfirst($faker->words(3, true).' '.$subCategoryName);

                // Create 10 Products per Subcategory
                for ($i = 0; $i < 10; $i++) {
                    $productName = $faker->words(3, true).' '.$subCategoryName;
                    $product = Product::create([
                        'name' => ucfirst($productName),
                        'slug' => Str::slug($productName.'-'.$faker->unique()->numberBetween(1000, 9999)),
                        'sku' => 'SKU-'.strtoupper($faker->unique()->lexify('????')).'-'.$faker->numberBetween(1000, 9999),
                        'short_description' => $faker->sentence,
                        'description' => $faker->paragraphs(3, true),
                        'status' => 'active',
                        'sort_order' => $faker->numberBetween(0, 100),
                    ]);

                    // Link Product to Subcategory
                    ProductSubCategory::create([
                        'product_id' => $product->id,
                        'sub_category_id' => $subCategory->id,
                    ]);

                    // Create Product Details
                    ProductDetail::create([
                        'product_id' => $product->id,
                        'thumbnail' => 'img/img-'.$faker->numberBetween(1, 10).'.png',
                        'weight' => $faker->randomFloat(2, 0.1, 10),
                        'length' => $faker->randomFloat(2, 5, 100),
                        'width' => $faker->randomFloat(2, 5, 100),
                        'height' => $faker->randomFloat(2, 5, 100),
                    ]);

                    // Create Product Pricing
                    $price = $faker->randomFloat(2, 10, 500);
                    ProductPricing::create([
                        'product_id' => $product->id,
                        'price' => $price,
                        'sale_price' => $faker->boolean(30) ? $price * 0.8 : null,
                        'cost_price' => $price * 0.6,
                        'stock_quantity' => $faker->numberBetween(0, 100),
                        'stock_status' => $faker->randomElement(['in_stock', 'out_of_stock', 'preorder']),
                    ]);

                    // Create Product Tags
                    for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                        ProductTag::create([
                            'product_id' => $product->id,
                            'name' => $faker->word,
                        ]);
                    }

                    // Create Product Files
                    for ($j = 0; $j < $faker->numberBetween(1, 2); $j++) {
                        ProductFile::create([
                            'product_id' => $product->id,
                            'file_path' => 'img/img-'.$faker->numberBetween(1, 10).'.png',
                        ]);
                    }
                }
            }
        }
    }
}

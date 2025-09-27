<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Relationships
    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function productPricing()
    {
        return $this->hasOne(ProductPricing::class);
    }

    public function productFiles()
    {
        return $this->hasMany(ProductFile::class);
    }

    public function productTags()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'product_sub_categories')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_sub_category', 'product_id', 'sub_category_id')
            ->join('sub_categories', 'product_sub_category.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id');
    }

    // Accessors
    public function getThumbnailAttribute()
    {
        return $this->productDetail?->thumbnail;
    }

    public function getPriceAttribute()
    {
        return $this->productPricing?->price ?? 0;
    }

    public function getSalePriceAttribute()
    {
        return $this->productPricing?->sale_price;
    }

    public function getStockQuantityAttribute()
    {
        return $this->productPricing?->stock_quantity ?? 0;
    }

    public function getStockStatusAttribute()
    {
        return $this->productPricing?->stock_status ?? 'out_of_stock';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->whereHas('productPricing', function ($q) {
            $q->where('stock_status', 'in_stock')
                ->where('stock_quantity', '>', 0);
        });
    }
}

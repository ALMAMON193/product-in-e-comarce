<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'is_featured',
        'status',
        'sort_order',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sub_category');
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

    public static function boot()
    {
        parent::boot();

        static::saving(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name);
            // Ensure unique slug
            $originalSlug = $subCategory->slug;
            $count = 1;
            while (static::where('slug', $subCategory->slug)->where('id', '!=', $subCategory->id)->exists()) {
                $subCategory->slug = $originalSlug.'-'.$count++;
            }
        });
    }
}

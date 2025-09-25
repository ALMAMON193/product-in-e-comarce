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

    /** Relationships */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function pricing()
    {
        return $this->hasOne(ProductPricing::class);
    }

    public function details()
    {
        return $this->hasOne(ProductDetail::class);
    }
}

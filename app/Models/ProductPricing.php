<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'stock_status',
    ];

    /** Relationships */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tags';

    protected $fillable = ['product_id', 'name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%'.$name.'%');
    }
}

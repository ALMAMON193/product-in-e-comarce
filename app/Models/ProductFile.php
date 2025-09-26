<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    protected $table = 'product_files';

    protected $fillable = ['product_id', 'file_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

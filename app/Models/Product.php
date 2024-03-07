<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }
    function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}

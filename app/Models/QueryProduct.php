<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryProduct extends Model
{
    use HasFactory;
    function getProduct(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

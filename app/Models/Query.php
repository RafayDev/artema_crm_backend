<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    public function getUser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function queryProduct(){
        return $this->belongsTo(QueryProduct::class, 'query_product_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySubCategory extends Model
{
    use HasFactory;
    function category(){
        return $this->belongsTo(Category::class);
    }
    function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
}

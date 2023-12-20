<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    use HasFactory;
    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

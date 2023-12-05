<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientQuery extends Model
{
    use HasFactory;
    function client_query_products()
    {
        return $this->hasMany(ClientQueryProduct::class, 'client_query_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

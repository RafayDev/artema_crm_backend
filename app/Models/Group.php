<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->hasMany(GroupUser::class, 'group_id', 'id');
    }
    public function twoLatestUsers()
    {
        return $this->hasMany(GroupUser::class, 'group_id', 'id')->latest()->take(2);
    }
}

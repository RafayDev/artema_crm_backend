<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmailAuthorization extends Model
{
    use HasFactory;
    protected $table = 'user_email_authorizations';
    protected $primaryKey = 'id';
}

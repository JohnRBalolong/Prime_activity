<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredentials extends Model
{
    use HasFactory;
    protected $table = 'user_accounts';

    protected $fillable = [
        'last_name',
        'first_name',
        'suffix',
        'email_address',
        'username',
        'password',

    ];

   
}


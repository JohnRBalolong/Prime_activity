<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fav_product_model extends Model
{
    use HasFactory;

    protected $table = 'product_favorites';

    protected $fillable = [
        'fav_product_name',
        'fav_product_image',
      

    ];
}

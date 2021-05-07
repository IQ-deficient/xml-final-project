<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
//    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'quantity',

        'is_active',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'product_id' => 'integer',
    ];

}

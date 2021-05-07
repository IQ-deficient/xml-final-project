<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtProductSupplier extends Model
{
//    use HasFactory;

    protected $table = 'mt_product_suppliers';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',

        'is_active',
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'product_id' => 'integer',
        'supplier_id' => 'integer',
    ];

}



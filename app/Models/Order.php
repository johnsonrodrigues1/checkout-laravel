<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'total',
        'status',
        'payment_method'
    ];

    protected $casts = [
        'payment_method' => 'integer',
        'payment_status' => 'integer',
    ];
}

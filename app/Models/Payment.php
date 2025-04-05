<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'customer_id',
        'payment_method',
        'amount',
        'status',
        'external_payment_id',
        'response_data',
        'payment_date',
    ];




    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'response_data' => 'array',
        'status' => PaymentStatus::class,
        'amount' => 'float',
        'payment_date' => 'datetime',
    ];
}

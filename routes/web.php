<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/{produto}', [CheckoutController::class, 'index'])
    ->name('checkout.index')
    ->where('produto', '[0-9]+');


Route::post('/processar-payment', [CheckoutController::class, 'processPayment'])
    ->name('checkout.processPayment');


Route::get('/teste', function () {


    $formData = [
        'customer' => [
            'name' => 'Johnson Rodrigues',
            'document' => '01730063373',
            'email' => 'johnsonrodrigues19@gmail.com',
            'phone' => '85986600760',
        ],
        'items' => [
            [
                'product_id' => 1,
                'quantity' => 2,
                'price' => 49.90,
            ],
        ],
        'total' => 199.70,
        'payment' => [
            'payment_method' => 1,
            'amount' => 199.70,
            'acquirer' => 1,
        ],
    ];

    $checkoutServices = app(\App\Services\CheckoutService::class);
    $checkoutServices->processCheckout($formData);

});

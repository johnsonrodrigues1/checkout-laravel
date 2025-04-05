<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders');
            $table->foreignId('customer_id')
                ->constrained('customers');
            $table->tinyInteger('payment_method')
                ->comment('1: PIX, 2: CREDIT_CARD, 3: BILLET');
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status')
                ->comment('1:CREATED, 2: PENDING, 3: PAID, 4:CANCELLED, 5: REFUNDED')
                ->default(1);
            $table->string('external_payment_id')->nullable();
            $table->json('response_data')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

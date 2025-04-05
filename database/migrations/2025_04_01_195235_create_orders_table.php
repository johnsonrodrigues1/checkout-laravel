<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->tinyInteger('status')
                ->comment('1 :CREATED, 2: PENDING, 3: PAID, 4:CANCELLED, 5: REFUNDED')
                ->default(1);
            $table->tinyInteger('payment_method')
                ->nullable()
                ->comment('1: PIX, 2: Credit Card, 3: Billet');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

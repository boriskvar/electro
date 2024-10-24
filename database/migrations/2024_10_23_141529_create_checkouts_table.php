<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ID пользователя (если он авторизован)
            $table->text('cart_items'); // Список товаров в корзине в формате JSON
            $table->decimal('total_price', 8, 2);
            $table->string('shipping_address')->nullable();
            $table->text('billing_information')->nullable(); // JSON с информацией для выставления счета
            $table->string('payment_method')->nullable();
            $table->decimal('discount', 8, 2)->nullable(); // Скидка
            $table->text('order_notes')->nullable(); // Примечания
            $table->timestamps();

            // Внешний ключ
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};

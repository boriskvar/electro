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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Делаем user_id необязательным
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1); // количество товаров
            $table->decimal('price', 8, 2); // цена товара
            $table->decimal('discount', 5, 2)->nullable(); // скидка на товар
            $table->decimal('total', 8, 2); // общая сумма
            $table->timestamps(); // даты создания и обновления

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
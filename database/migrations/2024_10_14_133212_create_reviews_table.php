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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Внешний ключ для продукта
            $table->unsignedBigInteger('user_id')->nullable(); // Внешний ключ для пользователя, может быть null для анонимных
            $table->string('author_name')->nullable(); // Имя автора, нужно для анонимных
            $table->string('email')->nullable(); // Email автора, нужно для анонимных
            $table->integer('rating')->default(1); // Рейтинг
            $table->text('review_text')->nullable(); // Текст отзыва
            $table->timestamps(); // Даты создания и обновления

            // Внешние ключи
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
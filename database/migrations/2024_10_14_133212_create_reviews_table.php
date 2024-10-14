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
            $table->string('author_name');
            $table->string('email');
            $table->integer('rating')->default(1); // Значение по умолчанию
            $table->text('review_text')->nullable();
            $table->timestamps(); // Автоматически создаст 'created_at' и 'updated_at'

            // Внешний ключ
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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

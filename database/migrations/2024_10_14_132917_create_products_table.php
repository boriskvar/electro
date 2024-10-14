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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // Уникальный slug для SEO
            $table->text('description')->nullable();
            $table->text('details')->nullable(); // Поле для детальной информации
            $table->decimal('price', 8, 2); // Основная цена
            $table->decimal('old_price', 8, 2)->nullable(); // Старая цена (если есть скидка)
            $table->boolean('in_stock')->default(true); // Есть в наличии или нет
            $table->decimal('rating', 2, 1)->nullable(); // Средний рейтинг (например, 4.5)
            $table->integer('reviews_count')->default(0); // Количество отзывов
            $table->integer('views_count')->default(0); // Количество просмотров продукта
            $table->json('images')->nullable(); // Массив изображений
            $table->json('colors')->nullable(); // Возможные цвета товара
            $table->json('sizes')->nullable(); // Возможные размеры товара
            $table->integer('qty')->default(0); // Количество товаров на складе
            $table->unsignedBigInteger('category_id'); // Внешний ключ для категории
            $table->unsignedBigInteger('brand_id')->nullable(); // Внешний ключ для бренда (необязательно)
            $table->timestamps();

            // Внешние ключи
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Внешний ключ для пользователя
            $table->decimal('total_price', 8, 2);
            $table->string('order_number')->unique(); // Уникальный номер заказа
            $table->string('status')->default('pending'); // Статус заказа
            $table->string('shipping_address')->nullable(); // Адрес доставки
            $table->string('billing_first_name')->nullable(); // Имя для выставления счета
            $table->string('billing_last_name')->nullable(); // Фамилия для выставления счета
            $table->string('billing_email')->nullable(); // Email для выставления счета
            $table->string('billing_city')->nullable(); // Город для выставления счета
            $table->string('billing_country')->nullable(); // Страна для выставления счета
            $table->string('billing_zip_code')->nullable(); // Почтовый индекс для выставления счета
            $table->string('billing_tel')->nullable(); // Телефон для выставления счета
            $table->dateTime('order_date')->nullable(); // Дата создания заказа
            $table->dateTime('delivery_date')->nullable(); // Ожидаемая дата доставки
            $table->string('payment_method')->nullable(); // Метод оплаты
            $table->string('shipping_status')->nullable(); // Статус доставки
            $table->decimal('discount', 8, 2)->nullable(); // Скидка или купон
            $table->text('order_notes')->nullable(); // Примечания к заказу
            $table->timestamps();

            // Внешние ключи
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

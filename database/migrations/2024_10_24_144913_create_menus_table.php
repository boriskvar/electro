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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(); // ID родительского пункта для подменю
            $table->string('name'); // название пункта меню
            $table->string('url');
            $table->integer('position')->default(0); // позиция в меню
            $table->boolean('is_active')->default(true); // активен ли пункт меню
            $table->timestamps(); // временные метки

            // Устанавливаем внешний ключ для parent_id
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};

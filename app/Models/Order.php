<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = ['user_id', 'total_price', 'status'];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с товарами через таблицу order_items
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status', // Например: "Выполнен", "В процессе выполнения", "Отменен"
        // новые поля
        'shipping_address',
        'order_date', //для хранения даты, когда заказ был размещен
        'delivery_date',
        'payment_method',
        'shipping_status',
        'discount',
    ];

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

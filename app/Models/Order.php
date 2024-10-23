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
        'order_notes'
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с элементами заказа
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Добавляем нужные поля в $casts для автоматического преобразования в даты (После этого поля будут автоматически конвертироваться в объекты Carbon, и вы сможете использовать метод format:)
    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    // Указываем, какие поля могут быть массово присвоены
    protected $fillable = [
        'user_id',
        'cart_items',
        'total_price',
        'shipping_address',
        'billing_information',
        'payment_method',
        'discount',
        'order_notes',
    ];

    // Определение связи с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

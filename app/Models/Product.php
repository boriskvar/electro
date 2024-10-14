<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    // Связь с категорией
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Связь с заказами (через таблицу order_items)
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }
}

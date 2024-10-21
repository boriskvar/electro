<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = [
        'name',
        'slug', // Уникальный slug для SEO
        'description',
        'details', // Поле для детальной информации
        'price',
        'old_price', // Старая цена (если есть скидка)
        'in_stock', // Есть в наличии или нет
        'rating', // Средний рейтинг
        'reviews_count', // Количество отзывов
        'views_count', // Количество просмотров
        'images', // Массив изображений
        'colors', // Возможные цвета товара
        'sizes', // Возможные размеры товара
        'qty', // Количество товаров на складе
        'category_id', // Внешний ключ для категории
        'brand_id', // Внешний ключ для бренда (необязательно)
        // Новые поля
        'is_top_selling',
        'discount_percentage',
        'is_new',
        'position',
    ];

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

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id'); // product_id — внешний ключ в таблице reviews
    }
}
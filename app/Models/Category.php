<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение этих полей
    protected $fillable = ['name', 'slug', 'description'];

    // Связь с продуктами
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Метод для получения дочерних категорий
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Метод для получения родительской категории
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
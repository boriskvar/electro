<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    // Определяем заполняемые поля
    protected $fillable = [
        'name', // название меню
        'url',  // ссылка на элемент меню
        'parent_id', // для вложенных меню, если нужно
        'position', // позиция в меню
        'is_active', // статус активности меню
    ];

    // Определяем отношения, если это необходимо
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}

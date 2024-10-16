<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Вывод списка категорий
    public function index()
    {
        // Получаем только родительские категории
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('categories.index', compact('categories'));
    }

    // Показать форму для создания новой категории
    public function create()
    {
        $categories = Category::all(); // Получаем все категории
        return view('categories.create', compact('categories')); // Передаем переменную в представление
    }

    // Сохранить новую категорию
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all()); // Сохранение новой категории

        return redirect()->route('categories.index')->with('success', 'Категория создана успешно!');
    }

    // Показать одну категорию
    public function show(Category $category)
    {
        //dd($category->toArray());
        return view('categories.show', compact('category'));
    }

    // Показать форму для редактирования категории
    public function edit(Category $category)
    {
        $categories = Category::all(); // Получаем все категории для выпадающего списка
        return view('categories.edit', compact('category', 'categories'));
    }

    // Обновить существующую категорию
    public function update(Request $request, Category $category)
    {
        // Валидация данных запроса
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Обновление категории только проверенными данными
        $category->update($validatedData);

        // Перенаправление с сообщением об успехе
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // Удалить категорию
    public function destroy(Category $category)
    {
        try {
            // Удаление категории
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            // Обработка ошибок при удалении
            return redirect()->route('categories.index')->with('error', 'An error occurred while deleting the category.');
        }
    }

}
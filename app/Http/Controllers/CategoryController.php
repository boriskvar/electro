<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    // Вывод списка категорий
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Показать форму для создания новой категории
    /*public function create()
    {
    return view('categories.create');
    }*/

    // Сохранить новую категорию
    /*public function store(Request $request)
    {
    $request->validate([
    'name' => 'required|string|max:255',
    'slug' => 'required|string|max:255|unique:categories,slug',
    // Добавь другие поля и правила валидации, если нужно
    ]);

    $category = Category::create($request->all());
    return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }*/

    // Показать одну категорию
    /*public function show(Category $category)
    {
    return view('categories.show', compact('category'));
    }*/

    // Показать форму для редактирования категории
    /*public function edit(Category $category)
    {
    return view('categories.edit', compact('category'));
    }*/

    // Обновить существующую категорию
    /*public function update(Request $request, Category $category)
    {
    $request->validate([
    'name' => 'required|string|max:255',
    'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
    // Добавь другие поля и правила валидации, если нужно
    ]);

    $category->update($request->all());
    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }*/

    // Удалить категорию
    /*public function destroy(Category $category)
{
$category->delete();
return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
}*/
}
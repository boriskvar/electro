<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Вывод списка продуктов
    public function index()
    {
        $products = Product::all(); // Получаем все продукты из базы данных
        return view('products.index', compact('products')); // Возвращаем представление с переданными данными
    }

    // Показать форму для создания нового продукта
    public function create()
    {
        $brands = collect(); // Создаем пустую коллекцию

        // Проверка на существование модели Brand
        if (class_exists('App\Models\Brand')) {
            $brands = Brand::all(); // Получаем все бренды
        }
        $categories = Category::all(); // Получаем все категории
        //$brands = Brand::all(); // Получаем все бренды
        return view('products.create', compact('categories', 'brands')); // Передаем переменную в представление
    }

    // Сохранить новый продукт
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'in_stock' => 'required|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'views_count' => 'nullable|integer|min:0',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'qty' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id', // Необязательный внешний ключ
            'images' => 'nullable|array', // Валидация для массива изображений
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Массив изображений с валидацией
        ]);

        // Собираем данные
        $data = $request->all();

// Преобразование и фильтрация массивов
        $data['colors'] = json_encode(array_filter($request->colors));
        $data['sizes'] = json_encode(array_filter($request->sizes));

        // Обработка загрузки изображений
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('img', 'public'); //  Сохраняем в папку public/img
                $imagePaths[] = $path; // Добавляем путь к изображению в массив
            }
            $data['images'] = json_encode($imagePaths); // Преобразуем массив путей в JSON
        } else {
            $data['images'] = json_encode([]); // Если нет изображений, сохраняем пустой массив
        }
        //dd($data);

        // Создаем продукт
        Product::create($data);

        // Редирект на список продуктов с сообщением об успехе
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Показать один продукт
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Показать форму для редактирования продукта
    public function edit(Product $product)
    {
        $categories = Category::all(); // Получаем все категории
        $brands = Brand::all(); // Получаем все бренды (если нужно)

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    // Обновить существующий продукт
    public function update(Request $request, Product $product)
    {
        // Валидация входящих данных
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'in_stock' => 'required|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'views_count' => 'nullable|integer|min:0',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'qty' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Валидация для изображений
        ]);

        // Собираем данные из запроса
        $data = $request->all();

        // Преобразуйте массивы в JSON
        $data['colors'] = json_encode($request->colors);
        $data['sizes'] = json_encode($request->sizes);

        // Обработка загрузки изображений
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('img', 'public'); // Сохраняем в папку public/img
                $imagePaths[] = str_replace('\\', '/', $path); // Приводим к правильному виду
            }
            $data['images'] = json_encode($imagePaths); // Преобразуем массив путей в JSON
        } else {
            $data['images'] = $product->images; // Сохраняем старые изображения, если новые не загружены
        }

        // Обновляем продукт
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // Удалить продукт
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}

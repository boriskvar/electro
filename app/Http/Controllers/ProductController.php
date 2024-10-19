<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $brands = Brand::all(); // Получаем все бренды
        return view('products.create', compact('categories', 'brands')); // Передаем переменную в представление
    }

    // Сохранить новый продукт
    public function store(Request $request)
    {
        //dd($request->all());
        // Удаляем null значения из массивов
        $request->merge([
            'colors' => array_filter($request->colors),
            'sizes' => array_filter($request->sizes),
        ]);

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
            'colors' => 'required|array',
            'colors.*' => 'required|string', // Обязательное поле для каждого элемента
            'sizes' => 'required|array',
            'sizes.*' => 'required|string', // Обязательное поле для каждого элемента
            'qty' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Собираем данные
        $data = $request->all();

        // Преобразование массивов в JSON перед сохранением
        $data['colors'] = json_encode($request->colors);
        $data['sizes'] = json_encode($request->sizes);

        //dd($request->all());
        // Отладка: выводим массивы colors и sizes
        //dd($request->colors, $request->sizes);
        //dd($data);

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
        //dd($product->images); //"["img/OzxpRcIK9jxYJOuouGZvYqmfzoxsjnM3Ru4rIaQu.png"]"
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

        // Преобразуем массивы в JSON
        $data['colors'] = json_encode($request->colors);
        $data['sizes'] = json_encode($request->sizes);

        // Обработка загрузки изображений
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('img', 'public'); // Сохранение изображения в storage/app/public/img
                $imagePaths[] = $path; // Сохраняем путь
            }
            $data['images'] = json_encode($imagePaths); // Преобразуем массив путей в JSON
        } else {
            $data['images'] = $product->images; // Сохраняем старые изображения, если новые не загружены
        }

        // Обновляем продукт
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Продукт обновлен успешно');
    }

    // Удалить продукт
    public function destroy(Product $product)
    {
        // Удаляем связанные изображения, если они есть
        if ($product->images) {
            $imagePaths = json_decode($product->images); // Декодируем пути к изображениям
            foreach ($imagePaths as $imagePath) {
                // Удаляем файл из файловой системы
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Удаляем продукт
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

}
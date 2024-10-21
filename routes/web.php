<?php
/*
Route::get('/', function () {
return view('welcome');
});
 */

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

// Маршрут для главной страницы
Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты для работы с категориями (CRUD)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index'); // Отображает список всех категорий (READ)
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create'); // Показывает форму для добавления новой категории (CREATE)
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store'); // Обрабатывает запрос на создание категории (CREATE)
    // Измените маршрут для show, edit, update и destroy, чтобы использовать модель
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show'); // Отображает детали конкретной категории (READ)
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Показывает форму для редактирования категории (UPDATE)
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Обрабатывает запрос на обновление категории (UPDATE)
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Удаляет категорию (DELETE)
});

// Маршруты для работы с продуктами (CRUD)
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Отображает список всех продуктов (READ)
    Route::get('/create', [ProductController::class, 'create'])->name('products.create'); // Показывает форму для добавления нового продукта (CREATE)
    Route::post('/', [ProductController::class, 'store'])->name('products.store'); // Обрабатывает запрос на создание продукта (CREATE)
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show'); // Отображает детали конкретного продукта (READ)
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Показывает форму для редактирования продукта (UPDATE)
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update'); // Обрабатывает запрос на обновление продукта (UPDATE)
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // Удаляет продукт (DELETE)
});

Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brands.index'); // Отображает список всех брендов (READ)
    Route::get('/create', [BrandController::class, 'create'])->name('brands.create'); // Показывает форму для добавления нового бренда (CREATE)
    Route::post('/', [BrandController::class, 'store'])->name('brands.store'); // Обрабатывает запрос на создание бренда (CREATE)
    Route::get('/{brand}', [BrandController::class, 'show'])->name('brands.show'); // Отображает детали конкретного бренда (READ)
    Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit'); // Показывает форму для редактирования бренда (UPDATE)
    Route::put('/{brand}', [BrandController::class, 'update'])->name('brands.update'); // Обрабатывает запрос на обновление бренда (UPDATE)
    Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy'); // Удаляет бренд (DELETE)
});

// Маршруты для работы с заказами (CRUD)
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index'); // Отображает список всех заказов (READ)
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create'); // Показывает ФОРМУ для создания нового заказа (CREATE)
    Route::post('/', [OrderController::class, 'store'])->name('orders.store'); // Обрабатывает запрос на создание заказа (CREATE)
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show'); // Отображает детали конкретного заказа (READ)
    Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit'); // Показывает ФОРМУ для редактирования заказа (UPDATE)
    Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update'); // Обрабатывает запрос на обновление заказа (UPDATE)
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Удаляет заказ (DELETE)
});

Route::prefix('order-items')->group(function () {
    Route::get('/', [OrderItemController::class, 'index'])->name('order-items.index'); // Отображает список всех элементов заказов (READ)
    Route::get('/create', [OrderItemController::class, 'create'])->name('order-items.create'); // Показывает ФОРМУ для создания нового элемента заказа (CREATE)
    Route::post('/', [OrderItemController::class, 'store'])->name('order-items.store'); // Обрабатывает запрос на создание элемента заказа (CREATE)
    Route::get('/{orderItem}', [OrderItemController::class, 'show'])->name('order-items.show'); // Отображает детали конкретного элемента заказа (READ)
    Route::get('/{orderItem}/edit', [OrderItemController::class, 'edit'])->name('order-items.edit'); // Показывает ФОРМУ для редактирования элемента заказа (UPDATE)
    Route::put('/{orderItem}', [OrderItemController::class, 'update'])->name('order-items.update'); // Обрабатывает запрос на обновление элемента заказа (UPDATE)
    Route::delete('/{orderItem}', [OrderItemController::class, 'destroy'])->name('order-items.destroy'); // Удаляет элемент заказа (DELETE)
});

// Группировка маршрутов для корзины
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index'); // Показать содержимое корзины
    Route::post('/add/{product_id}', [CartController::class, 'add'])->name('cart.add'); // Добавить товар в корзину
    Route::post('/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove'); // Удалить товар из корзины
    Route::post('/update/{product_id}', [CartController::class, 'update'])->name('cart.update'); // Обновить количество товара в корзине
});

// Маршруты для оформления заказа
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index'); // Показать страницу оформления заказа
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store'); // Обработать оформление заказа
});


/*Route::prefix('reviews')->group(function () {
Route::post('/store', [ReviewController::class, 'store'])->name('reviews.store'); // Добавить отзыв
Route::get('/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit'); // Редактировать отзыв
Route::put('/{id}', [ReviewController::class, 'update'])->name('reviews.update'); // Обновить отзыв
Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy'); // Удалить отзыв
});*/

//Auth::routes();
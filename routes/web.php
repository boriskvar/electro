<?php
/*
Route::get('/', function () {
return view('welcome');
});
 */

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Маршрут для главной страницы (например, Home)
Route::get('/', function () {
    return view('home'); // Отображает главную страницу магазина
})->name('home');

// Маршруты для работы с продуктами (CRUD)
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Отображает список всех продуктов (READ)
    Route::get('/create', [ProductController::class, 'create'])->name('products.create'); // Показывает форму для добавления нового продукта (CREATE)
    Route::post('/', [ProductController::class, 'store'])->name('products.store'); // Обрабатывает запрос на создание продукта (CREATE)
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show'); // Отображает детали конкретного продукта (READ)
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Показывает форму для редактирования продукта (UPDATE)
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update'); // Обрабатывает запрос на обновление продукта (UPDATE)
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Удаляет продукт (DELETE)
});

// Маршруты для работы с категориями (CRUD)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index'); // Отображает список всех категорий (READ)
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create'); // Показывает форму для добавления новой категории (CREATE)
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store'); // Обрабатывает запрос на создание категории (CREATE)
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show'); // Отображает детали конкретной категории (READ)
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Показывает форму для редактирования категории (UPDATE)
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update'); // Обрабатывает запрос на обновление категории (UPDATE)
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Удаляет категорию (DELETE)
});

// Маршруты для работы с заказами (CRUD)
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index'); // Отображает список всех заказов (READ)
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create'); // Показывает форму для создания нового заказа (CREATE)
    Route::post('/', [OrderController::class, 'store'])->name('orders.store'); // Обрабатывает запрос на создание заказа (CREATE)
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show'); // Отображает детали конкретного заказа (READ)
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit'); // Показывает форму для редактирования заказа (UPDATE)
    Route::put('/{id}', [OrderController::class, 'update'])->name('orders.update'); // Обрабатывает запрос на обновление заказа (UPDATE)
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Удаляет заказ (DELETE)
});

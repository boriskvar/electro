<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Вывод списка продуктов
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Показать форму для создания нового продукта
    public function create()
    {
        return view('products.create');
    }

    // Сохранить новый продукт
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    // Показать один продукт
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Показать форму для редактирования продукта
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Обновить существующий продукт
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // Удалить продукт
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}

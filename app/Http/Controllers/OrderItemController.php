<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::all();
        return view('order_items.index', compact('orderItems'));
    }

    public function create()
    {
        $products = Product::all(); // Получаем все продукты
        $orders = Order::all(); // Получаем все заказы
        return view('order_items.create', compact('products', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id', // Валидация для заказа
            'product_id' => 'required|exists:products,id', // Проверка существования продукта
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Для одного изображения
        ]);

        $data = $request->all();

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('order_items', 'public'); // Сохраняем в папку public/storage/order_items
            $data['image'] = $path; // Сохраняем путь к изображению
        } else {
            $data['image'] = null; // Если нет изображения, сохраняем null
        }

        OrderItem::create($data);

        return redirect()->route('order-items.index')->with('success', 'Элемент заказа создан успешно.');
    }

    public function show(OrderItem $orderItem)
    {
        // Получаем родительский заказ
        $order = $orderItem->order; // Предполагается, что у вас есть отношение 'order' в модели OrderItem

        return view('order_items.show', compact('orderItem', 'order'));
    }

    public function edit(OrderItem $orderItem)
    {
        // Получаем все заказы для выпадающего списка
        $orders = Order::all();

        // Получаем все продукты для выпадающего списка
        $products = Product::all();

        // Передаем $orders и $products в представление, а также сам элемент заказа
        return view('order_items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        // Валидация входящих данных
        $request->validate([
            'order_id' => 'required|exists:orders,id', // Валидация для заказа
            'product_id' => 'required|exists:products,id', // Проверка существования продукта
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Валидация для изображения
        ]);

        // Обновление данных элемента заказа
        $data = $request->all();

        // Проверка, было ли загружено новое изображение
        if ($request->hasFile('image')) {
            // Удаление старого изображения, если оно есть
            if ($orderItem->image && file_exists(public_path('storage/' . $orderItem->image))) {
                unlink(public_path('storage/' . $orderItem->image));
            }

            // Сохранение нового изображения
            $path = $request->file('image')->store('order_items', 'public');
            $data['image'] = $path; // Обновление пути изображения
        }

        // Обновление элемента заказа
        $orderItem->update($data);

        // Перенаправление на страницу списка элементов заказа
        return redirect()->route('order-items.index')->with('success', 'Элемент заказа обновлен успешно.');
    }

    public function destroy(OrderItem $orderItem)
    {
        try {
            // Проверка, если у элемента заказа есть изображение
            if ($orderItem->image && file_exists(public_path('storage/' . $orderItem->image))) {
                // Удаление изображения из файловой системы
                unlink(public_path('storage/' . $orderItem->image));
            }

            // Удаление элемента заказа
            $orderItem->delete();

            return redirect()->route('order-items.index')->with('success', 'Элемент заказа успешно удален.');
        } catch (\Exception $e) {
            return redirect()->route('order-items.index')->with('error', 'Ошибка при удалении элемента заказа: ' . $e->getMessage());
        }
    }

}
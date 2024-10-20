<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Вывод списка заказов
    public function index()
    {
        $orders = Order::with('user')->get(); // Получаем заказы вместе с пользователями
        return view('orders.index', compact('orders'));
    }

    // Показать один заказ
    public function show(Order $order)
    {
        // Получаем всех пользователей для выпадающего списка
        $users = User::all();

        return view('orders.show', compact('order', 'users'));
    }

    // Показать форму для редактирования заказа
    public function edit(Order $order)
    {
        // Получаем всех пользователей для выпадающего списка
        $users = User::all();

        return view('orders.edit', compact('order', 'users'));
    }

    // Показать форму для создания нового заказа
    public function create()
    {
        // Генерация номера заказа
        $orderNumber = 'ORD-' . date('Ymd-His'); // Пример: ORD-20231019-153045
        $users = User::all(); // Предполагается, что есть модель User
        //dd($users);
        return view('orders.create', compact('orderNumber', 'users'));
    }

    // Сохранить новый заказ
    public function store(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string|max:255|unique:orders,order_number', // Валидация для номера заказа
            'user_id' => 'required|exists:users,id', // Проверка существования пользователя
            'total_price' => 'required|numeric',
            'status' => 'required|string',
            'shipping_address' => 'nullable|string',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'payment_method' => 'required|string',
            'shipping_status' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);
        //dd($request);
        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Заказ создан успешно.');
    }

    // Обновить существующий заказ
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'shipping_address' => 'nullable|string|max:255',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'payment_method' => 'required|string',
            'shipping_status' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно обновлен');
    }

    // Удалить заказ
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Заказ успешно удален.');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Ошибка при удалении заказа: ' . $e->getMessage());
        }
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Вывод списка заказов
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    // Показать один заказ
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    // Показать форму для создания нового заказа
    public function create()
    {
        return view('orders.create');
    }

    // Сохранить новый заказ
    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    // Обновить существующий заказ
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    // Удалить заказ
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}

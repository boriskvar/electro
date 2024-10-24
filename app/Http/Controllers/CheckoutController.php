<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart; // Убедитесь, что модель Cart импортирована
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Показать страницу оформления заказа
    public function index()
    {
        $userId = Auth::id(); // Получаем ID текущего пользователя
        $cartItems = Cart::where('user_id', $userId)->get(); // Получаем товары в корзине

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста.');
        }

        return view('checkout.index', compact('cartItems'));
    }

    // Обработать оформление заказа
    public function store(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            // Добавьте другие необходимые поля
        ]);

        // Создаем новый заказ
        $order = new Order();
        $order->user_id = Auth::id();
        $order->shipping_address = $request->input('shipping_address');
        $order->payment_method = $request->input('payment_method');
        // Заполните остальные поля заказа

        // Сохраните заказ в базе данных
        $order->save();

        // Здесь можно удалить товары из корзины после оформления заказа
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('checkout.index')->with('success', 'Заказ оформлен успешно.');
    }
}

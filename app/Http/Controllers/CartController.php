<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // модель товара
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    // Показать содержимое корзины
    public function index()
    {
        //$userId = Auth::id(); // Получаем ID текущего пользователя
        $userId = 1; // Используем временный ID пользователя для тестирования
        $cartItems = Cart::where('user_id', $userId)->get(); // Получаем все товары в корзине пользователя
        //dd($cartItems); //[] пустой массив
        // Передаем товары в корзине в представление
        return view('cart.index', compact('cartItems'));
    }

    // Добавить товар в корзину
    public function add($product_id, Request $request)
    {
        //$userId = Auth::id();

        // Временно используем временный ID пользователя для тестирования
        $userId = 1; // Замените на Auth::id() для продакшн-версии

        // Находим товар по ID или выбрасываем 404, если не найден
        $product = Product::findOrFail($product_id);


        // Валидация входящих данных
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Проверяем, есть ли товар в корзине
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->first();

        if ($cartItem) {
            // Если товар уже в корзине, увеличиваем количество
            $cartItem->quantity += $request->input('quantity', 1);
        } else {
            // Если товара нет в корзине, создаем новую запись
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $product->id;
            $cartItem->quantity = $request->input('quantity', 1);
            $cartItem->price = $product->price;
        }

        // Рассчитываем общую сумму для позиции в корзине
        $cartItem->total = $cartItem->quantity * $cartItem->price;

        // Сохраняем товар в корзину
        $cartItem->save();

        // Перенаправляем с сообщением об успешном добавлении товара в корзину
        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину.');
    }

    // Обновить количество товара в корзине
    public function update($product_id, Request $request)
    {
        //dd($request->all()); //"quantity" => "3"

        // Получаем ID текущего пользователя
        //$userId = Auth::id();
        $userId = 1; // Замените на Auth::id() для продакшн-версии


        // Получаем элемент корзины
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->first();
        //dd($cartItem->toArray()); // "quantity" => 2

        // Проверяем, существует ли элемент корзины
        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Товар не найден в вашей корзине');
        }

        // Валидация входящих данных
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        //dd($validatedData); // Проверяем валидированные данные ["quantity" => "2"]

        // Обновляем количество и общую сумму
        $cartItem->quantity = $validatedData['quantity'];
        $cartItem->total = $cartItem->quantity * $cartItem->price;

        //dd($cartItem->toArray()); //"quantity" => "2"


        // Сохраняем изменения в базе данных
        $cartItem->save();

        // Перенаправляем на страницу корзины с сообщением об успешном обновлении;
        return redirect()->route('cart.index')->with('success', 'Количество товара обновлено');
    }

    // Удалить товар из корзины
    public function remove($product_id)
    {
        // Получаем ID текущего пользователя
        //$userId = Auth::id();
        $userId = 1; // Замените на Auth::id() для продакшн-версии

        // Находим товар в корзине или возвращаем 404, если не найден
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->firstOrFail();

        //dd($cartItem); // Посмотрим, что мы получили

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Товар не найден в корзине');
        }

        // Удаляем элемент корзины
        $cartItem->delete();

        // Перенаправляем на страницу корзины с сообщением об успешном удалении
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}

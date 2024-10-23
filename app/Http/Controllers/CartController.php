<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // модель товара
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    // Показать содержимое корзины
    public function index()
    {
        //$userId = Auth::id(); // Получаем ID текущего пользователя
        $userId = 1; // Используем временный ID пользователя для тестирования
        $cartItems = Cart::where('user_id', $userId)->get(); // Получаем все товары в корзине пользователя

        // Передаем товары в корзине в представление
        return view('cart.index', compact('cartItems'));
    }

    // Добавить товар в корзину
    public function add($product_id, Request $request)
    {
        //$userId = Auth::id();

        /*if (!$userId) {
            return response()->json(['error' => 'Пожалуйста, войдите в систему, чтобы добавить товары в корзину.'], 401);
        }*/
        // Временно используем временный ID пользователя для тестирования
        $userId = 1; // Замените на Auth::id() для продакшн-версии

        $product = Product::findOrFail($product_id); // Находим товар по ID
        //dd($product->toArray());
        // Валидация входящих данных
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        //dd($request->toArray()); //"quantity" => "1"
        // Проверяем, есть ли товар в корзине
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->first();
        //dd($cartItem); //null
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
            //dd($cartItem->toArray());
        }
        /* 
array:4 [▼ // app\Http\Controllers\CartController.php:54
  "user_id" => 1
  "product_id" => 1
  "quantity" => "1"
  "price" => "950.00"
]
*/
        // Рассчитываем общую сумму
        $cartItem->total = $cartItem->quantity * $cartItem->price;
        //dd($cartItem->toArray());
        $cartItem->save();
        //dd($cartItem->toArray());
        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }


    // Удалить товар из корзины
    public function remove($product_id)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }

    // Обновить количество товара в корзине
    public function update($product_id, Request $request)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $product_id)->firstOrFail();

        $cartItem->quantity = $request->input('quantity');
        $cartItem->total = $cartItem->quantity * $cartItem->price;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Количество товара обновлено');
    }
}
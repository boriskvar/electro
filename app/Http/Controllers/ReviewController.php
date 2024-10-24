<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Метод для добавления нового отзыва
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5', // Оценка от 1 до 5
            'review_text' => 'nullable|string',
        ]);

        // Создаем новый отзыв
        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), // Если пользователь авторизован
            'author_name' => $request->author_name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->route('products.show', $product->id)->with('success', 'Отзыв успешно добавлен!');
    }

    // Метод для редактирования отзыва
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    // Метод для обновления отзыва
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'nullable|string',
        ]);

        // Обновляем отзыв
        $review->update([
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->route('products.show', $review->product_id)->with('success', 'Отзыв успешно обновлен!');
    }

    // Метод для удаления отзыва
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('products.show', $review->product_id)->with('success', 'Отзыв успешно удален!');
    }
}

@extends('home')

@section('content')

<div class="container">
    <h1>{{ $product->name }}</h1>

    <div class="product-details">
        @php
        $images = json_decode($product->images, true);
        @endphp

        @if($images && isset($images[0]) && file_exists(public_path('storage/img/' . basename($images[0]))))
        <img src="{{ asset('storage/img/' . basename($images[0])) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 100px;">
        @else
        <p>Изображение недоступно</p>
        @endif

        <h3>Slug</h3>
        <p>{{ $product->slug }}</p>

        <h3>Описание</h3>
        <p>{{ $product->description }}</p>

        <h3>Детали</h3>
        <p>{{ $product->details }}</p>

        <h3>Цена</h3>
        <p>${{ number_format($product->price, 2) }}</p>

        @if($product->old_price)
        <h3>Старая цена</h3>
        <p><s>${{ number_format($product->old_price, 2) }}</s></p>
        @endif

        <h3>В наличии</h3>
        <p>{{ $product->in_stock ? 'Да' : 'Нет' }}</p>

        <h3>Рейтинг</h3>
        <p>{{ $product->rating }} / 5</p>

        <h3>Количество отзывов</h3>
        <p>{{ $product->reviews_count }}</p>

        <h3>Количество просмотров</h3>
        <p>{{ $product->views_count }}</p>

        <h3>Цвета</h3>
        <p>{{ json_decode($product->colors) ? implode(', ', json_decode($product->colors)) : 'Нет' }}</p>

        <h3>Размеры</h3>
        <p>{{ json_decode($product->sizes) ? implode(', ', json_decode($product->sizes)) : 'Нет' }}</p>

        <h3>Количество на складе</h3>
        <p>{{ $product->qty }}</p>

        <h3>Категория</h3>
        <p>{{ $product->category ? $product->category->name : 'Категория не указана' }}</p>

        <h3>Бренд</h3>
        <p>{{ $product->brand_id ? $product->brand->name : 'Не указано' }}</p>

        <h3>Популярный товар</h3>
        <p>{{ $product->is_top_selling ? 'Да' : 'Нет' }}</p>

        <h3>Скидка (%)</h3>
        <p>{{ $product->discount_percentage ? $product->discount_percentage . '%' : 'Нет' }}</p>

        <h3>Новый товар</h3>
        <p>{{ $product->is_new ? 'Да' : 'Нет' }}</p>

        <h3>Позиция</h3>
        <p>{{ $product->position }}</p>

        <h3>Добавить в корзину</h3>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <label for="quantity">Количество:</label>
            <input type="number" name="quantity" value="1" min="1" max="{{ $product->in_stock }}" class="form-control" style="width: 100px; display: inline-block;">
            <button type="submit" class="btn btn-primary">Добавить в корзину</button>
        </form>
    </div>

    <h3>Отзывы</h3>
    @if($product->reviews->isEmpty())
    <p>Нет отзывов для этого продукта.</p>
    @else
    <ul>
        @foreach($product->reviews as $review)
        <div class="review">
            <strong>{{ $review->author_name }}</strong> ({{ $review->rating }} звёзд)
            <p>{{ $review->review_text }}</p>
            <small>Отзыв оставлен {{ $review->created_at->diffForHumans() }}</small>

            @if(auth()->id() === $review->user_id)
            <!-- Проверка, если пользователь является автором отзыва -->
            <div>
                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-warning">Редактировать</a>
                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
            @endif
        </div>
        @endforeach

    </ul>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-primary">Назад к списку товаров</a>

    <div class="navigation">
        @if ($previousProduct)
        <a href="{{ route('products.show', $previousProduct->id) }}" class="btn btn-secondary">← Предыдущий</a>
        @endif

        @if ($nextProduct)
        <a href="{{ route('products.show', $nextProduct->id) }}" class="btn btn-secondary">Следующий →</a>
        @endif
    </div>
</div>

@endsection

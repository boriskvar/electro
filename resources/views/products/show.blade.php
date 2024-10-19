@extends('home')

@section('content')

<div class="container">
    {{-- <h3>Название товара</h3> --}}
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
        <p>${{ number_format($product->price, 2) }}</p> // используется number_format, чтобы отобразить цену с двумя знаками после запятой.

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

    </div>

    <a href="{{ route('products.index') }}" class="btn btn-primary">Назад к списку товаров</a>
</div>

@endsection

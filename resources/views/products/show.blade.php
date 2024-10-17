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
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-primary">Назад к списку товаров</a>
</div>

@endsection

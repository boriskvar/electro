@extends('home')

@section('content')
<div class="container">
    <h1>Редактирование товаров в заказе</h1>
    <form action="{{ route('order-items.update', $orderItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="order_id">Выберите заказ:</label>
            <select class="form-control" id="order_id" name="order_id" required>
                <option value="">Выберите заказ</option>
                @foreach ($orders as $order)
                <option value="{{ $order->id }}" {{ $orderItem->order_id == $order->id ? 'selected' : '' }}>
                    {{ $order->order_number }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="product_id">Продукт:</label>
            <select class="form-control" id="product_id" name="product_id" required>
                <option value="">Выберите продукт</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $orderItem->product_id == $product->id ? 'selected' : '' }}>
                    {{ $product->name }} (Цена: {{ $product->price }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Количество:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $orderItem->quantity }}" required>
        </div>

        <div class="form-group">
            <label for="price">Цена за еденицу:</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $orderItem->price }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="images">Изображение:</label>
            @if ($orderItem->product && $orderItem->product->images)
            @php
            // Предполагаем, что поле images содержит JSON массив
            $images = json_decode($orderItem->product->images, true);
            $firstImage = $images[0] ?? null;
            @endphp
            @if ($firstImage && file_exists(public_path('storage/' . $firstImage)))
            <div>
                <img src="{{ asset('storage/' . $firstImage) }}" alt="Изображение товара" style="width: 100px; height: auto;">
            </div>
            @else
            <p>Изображение недоступно</p>
            @endif
            @else
            <p>Изображение недоступно</p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Обновить товары в заказе</button>

        <a href="{{ route('order-items.index', ['order' => $order->id]) }}" class="btn btn-warning">Назад к списку товаров в заказе</a>
    </form>
</div>
@endsection

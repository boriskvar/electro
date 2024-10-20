@extends('home')

@section('content')
<div class="container">
    <h1>Создание деталей заказа</h1>
    <form action="{{ route('order-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="order_id">Выберите заказ:</label>
            <select class="form-control" id="order_id" name="order_id" required>
                <option value="">Выберите заказ</option>
                @foreach ($orders as $order)
                <option value="{{ $order->id }}">{{ $order->order_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="product_id">Продукт:</label>
            <select class="form-control" id="product_id" name="product_id" required>
                <option value="">Выберите продукт</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (Цена за единицу: {{ $product->price }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Количество:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>

        <div class="form-group">
            <label for="price">Цена за единицу:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="image">Изображение:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Создать детали заказа</button>
        <a href="{{ route('order-items.index') }}" class="btn btn-warning">Назад к списку деталей заказов</a>
    </form>
</div>
@endsection
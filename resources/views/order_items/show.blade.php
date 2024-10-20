@extends('home')

@section('content')
<div class="container">
    <h1>Элементы заказа №{{ $order->order_number }}</h1>

    <div class="order-item-details">
        <p><strong>Продукт:</strong> {{ $orderItem->product->name }}</p>
        <p><strong>Количество:</strong> {{ $orderItem->quantity }}</p>
        <p><strong>Цена за еденицу:</strong> {{ $orderItem->price }}</p>
        <p><strong>Изображение:</strong></p>
        @if($orderItem->image)
        <img src="{{ asset('storage/' . $orderItem->image) }}" alt="Изображение продукта" style="max-width: 200px;">
        @else
        <span>Нет изображения</span>
        @endif
    </div>

    <h2>Детали заказа</h2>
    <div class="order-details">
        <p><strong>Статус заказа:</strong> {{ $order->status }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Дата заказа:</strong> {{ $order->order_date }}</p>
        <p><strong>Дата доставки:</strong> {{ $order->delivery_date }}</p>
        <p><strong>Метод оплаты:</strong> {{ $order->payment_method }}</p>
        <p><strong>Статус доставки:</strong> {{ $order->shipping_status }}</p>
        <p><strong>Скидка:</strong> {{ $order->discount }}%</p>
    </div>

    <a href="{{ route('order-items.index') }}" class="btn btn-warning">Назад к списку элементов заказа</a>
</div>
@endsection

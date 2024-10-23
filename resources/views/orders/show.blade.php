@extends('home')

@section('content')

<div class="container">
    {{-- {{ dd($order->toArray()) }} --}}
    <h1>Заказ №{{ $order->order_number }}</h1>

    <div class="order-details">
        <p><strong>Пользователь:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Общая цена:</strong> {{ $order->total_price }}</p>
        <p><strong>Статус заказа:</strong> {{ $order->status }}</p>
        <p><strong>Дата заказа:</strong> {{ $order->order_date }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Дата доставки:</strong> {{ $order->delivery_date }}</p>
        <p><strong>Варианты доставки:</strong> {{ $order->shipping_status }}</p>
        <p><strong>Метод оплаты:</strong> {{ $order->payment_method }}</p>
        <p><strong>Скидка:</strong> {{ $order->discount }}%</p>
    </div>

    <h2>Товары в заказе</h2>
    @if($order->orderItems->isNotEmpty())
    <ul>
        @foreach($order->orderItems as $orderItem)
        <li>
            {{-- Проверяем, есть ли изображение и оно не пустое --}}
            @php
            $imagePath = json_decode($orderItem->product->images, true);
            @endphp

            @if (!empty($imagePath) && isset($imagePath[0]))
            <img src="{{ asset('storage/' . $imagePath[0]) }}" alt="{{ $orderItem->product->name }}" style="width: 50px; height: auto;">
            @else
            <img src="{{ asset('storage/default.png') }}" alt="No image" style="width: 50px; height: auto;"> <!-- Заглушка -->
            @endif

            <a href="{{ route('products.show', $orderItem->product_id) }}">{{ $orderItem->product->name }}</a>
            - {{ number_format($orderItem->price, 2) }} грн.
            ({{ $orderItem->quantity }} шт.)
        </li>
        @endforeach
    </ul>
    @else
    <p>Нет товаров в заказе.</p>
    @endif

    <a href="{{ route('orders.index') }}" class="btn btn-warning">Назад к списку заказов</a>
</div>

@endsection

@extends('home')

@section('content')

<div class="container">
    {{-- {{ dd($order->toArray()) }} --}}
    <h1>Заказ №{{ $order->order_number }}</h1>

    <div class="order-details">
        <p><strong>Пользователь:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Общая цена:</strong> {{ $order->total_price }}</p>
        <p><strong>Статус заказа:</strong> {{ $order->status }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Дата заказа:</strong> {{ $order->order_date }}</p>
        <p><strong>Дата доставки:</strong> {{ $order->delivery_date }}</p>
        <p><strong>Метод оплаты:</strong> {{ $order->payment_method }}</p>
        <p><strong>Статус доставки:</strong> {{ $order->shipping_status }}</p>
        <p><strong>Скидка:</strong> {{ $order->discount }}%</p>
    </div>

    <h2>Товары в заказе</h2>
    @if($order->products->isNotEmpty())
    <ul>
        @foreach($order->products as $product)
        <li>
            <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
            - {{ number_format($product->pivot->price, 2) }} руб.
            ({{ $product->pivot->quantity }} шт.)
        </li>
        @endforeach
    </ul>
    @else
    <p>Нет товаров в заказе.</p>
    @endif

    <a href="{{ route('orders.index') }}" class="btn btn-warning">Назад к списку заказов</a>
</div>

@endsection

@extends('home')

@section('content')
<div class="container">
    <h1>Корзина</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($cartItems->isEmpty())
    <p>Ваша корзина пуста.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Продолжить покупки</a>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Название</th>
                <th>Цена за единицу</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
            <tr>
                <td><img src="{{ asset('img/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="100"></td>
                <td>{{ $item->product->name }} <br> Продавец: {{ $item->product->seller }}</td>
                <td>{{ $item->price }} ₽</td>
                <td>
                    <form action="{{ route('cart.update', $item->product->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="100">
                        <button type="submit" class="btn btn-primary">Обновить</button>
                    </form>
                </td>
                <td>{{ $item->total }} ₽</td>
                <td>
                    <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <p><strong>Итого: {{ $cartItems->sum('total') }} ₽</strong></p>
        <a href="{{ route('checkout') }}" class="btn btn-success">Оформить заказ</a>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Продолжить покупки</a>
    @endif
</div>
@endsection

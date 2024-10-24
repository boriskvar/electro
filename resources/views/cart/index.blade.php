@extends('home')

@section('content')
<div class="container">
    <h1>Корзина</h1>

    {{-- Сообщение об успешной операции --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Сообщение об ошибке --}}
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
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
                <td>
                    @php
                    // Получаем изображение продукта из JSON
                    $images = json_decode($item->product->images, true);
                    $firstImage = $images[0] ?? null;
                    @endphp
                    @if ($firstImage)
                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->product->name }}" width="50">
                    @else
                    <p>Изображение недоступно</p>
                    @endif
                </td>
                <td>{{ $item->product->name }} <br> Продавец: {{ $item->product->seller }}</td>
                <td>{{ number_format($item->price, 2, ',', ' ') }} ₽</td>
                <td>
                    <form action="{{ route('cart.update', $item->product->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="100" class="form-control" style="width: 70px; display: inline;">
                        <button type="submit" class="btn btn-primary btn-sm">Изменить</button>
                    </form>
                </td>
                <td>{{ number_format($item->total, 2, ',', ' ') }} ₽</td>
                <td>
                    <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <p><strong>Итого: {{ number_format($cartItems->sum('total'), 2, ',', ' ') }} ₽</strong></p>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">Оформить заказ</a>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-warning mt-3">Продолжить покупки</a>
    @endif
</div>
@endsection

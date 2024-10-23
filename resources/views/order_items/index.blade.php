@extends('home')

@section('content')

<div class="container">
    <h1>Список товаров в заказе</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <a href="{{ route('order-items.create') }}" class="btn btn-primary mb-3">Добавить товар в заказ</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Номер заказа</th>
                <th>Название продукта</th>
                <th>Количество</th>
                <th>Цена (за ед.)</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->id }}</td>
                <td>{{ $orderItem->order->order_number }}</td>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ $orderItem->quantity }}</td>
                <td>{{ number_format($orderItem->price, 2, '.', '') }} ₴</td> <!-- Форматирование цены -->
                <td>
                    @if($orderItem->image && file_exists(public_path('storage/' . $orderItem->image)))
                    <img src="{{ asset('storage/' . $orderItem->image) }}" alt="Изображение товара" class="img-fluid" style="max-width: 50px;">
                    @else
                    <p>Изображение недоступно</p>
                    @endif
                </td>

                <td>
                    <a href="{{ route('order-items.show', $orderItem->id) }}" class="btn btn-info">Посмотреть</a>
                    <a href="{{ route('order-items.edit', $orderItem->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($orderItems->isEmpty())
    <div class="alert alert-warning">Нет товаров в заказе.</div> <!-- Сообщение, если нет элементов -->
    @endif
</div>
@endsection

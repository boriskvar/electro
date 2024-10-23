@extends('home')

@section('content')
<div class="container">
    <h1>Список заказов</h1>
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

    <a href="{{ route('orders.create') }}" class="btn btn-primary">Создать новый заказ</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Номер заказа</th>
                <th>Пользователь</th>
                <th>Цена (Σ)</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                <td>{{ $order->total_price }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">Посмотреть</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

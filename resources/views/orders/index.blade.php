@extends('home')

@section('content')
<div class="container">
    <h1>Список заказов</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Создать новый заказ</a>
    <table class="table">
        <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Пользователь</th>
                <th>Общая цена</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
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

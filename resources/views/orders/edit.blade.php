@extends('home')

@section('content')
<div class="container">
    <h1>Редактирование заказа №{{ $order->order_number }}</h1>
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Поле выбора пользователя -->
        <div class="form-group">
            <label for="user_id">Пользователь:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Выберите пользователя</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Номер заказа -->
        <div class="form-group">
            <label for="order_number">Номер заказа:</label>
            <input type="text" class="form-control" id="order_number" name="order_number" value="{{ $order->order_number }}" readonly>
        </div>

        <!-- Общая цена -->
        <div class="form-group">
            <label for="total_price">Общая цена:</label>
            <input type="number" class="form-control" id="total_price" name="total_price" value="{{ $order->total_price }}" required>
        </div>

        <!-- Статус заказа -->
        <div class="form-group">
            <label for="status">Статус заказа:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="выполнен" {{ $order->status == 'выполнен' ? 'selected' : '' }}>Выполнен</option>
                <option value="в процессе выполнения" {{ $order->status == 'в процессе выполнения' ? 'selected' : '' }}>В процессе выполнения</option>
                <option value="отменен" {{ $order->status == 'отменен' ? 'selected' : '' }}>Отменен</option>
            </select>
        </div>

        <!-- Адрес доставки -->
        <div class="form-group">
            <label for="shipping_address">Адрес доставки:</label>
            <input type="text" class="form-control" id="shipping_address" name="shipping_address" value="{{ $order->shipping_address }}">
        </div>

        <!-- Дата заказа -->
        <div class="form-group">
            <label for="order_date">Дата заказа:</label>
            <input type="date" class="form-control" id="order_date" name="order_date" value="{{ $order->order_date ? $order->order_date->format('Y-m-d') : '' }}" required>
        </div>

        <!-- Дата доставки -->
        <div class="form-group">
            <label for="delivery_date">Дата доставки:</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="{{ $order->delivery_date ? $order->delivery_date->format('Y-m-d') : '' }}">
        </div>

        <!-- Метод оплаты -->
        <div class="form-group">
            <label for="payment_method">Метод оплаты:</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="предоплата" {{ $order->payment_method == 'предоплата' ? 'selected' : '' }}>Предоплата</option>
                <option value="при получении" {{ $order->payment_method == 'при получении' ? 'selected' : '' }}>При получении</option>
            </select>
        </div>

        <!-- Статус доставки -->
        <div class="form-group">
            <label for="shipping_status">Доставка:</label>
            <select class="form-control" id="shipping_status">
                <option value="курьером" {{ $order->shipping_status == 'курьером' ? 'selected' : '' }}>Курьером</option>
                <option value="почтой" {{ $order->shipping_status == 'почтой' ? 'selected' : '' }}>Почтой</option>
                <option value="самовывоз" {{ $order->shipping_status == 'самовывоз' ? 'selected' : '' }}>Самовывоз</option>
            </select>
        </div>

        <!-- Скидка -->
        <div class="form-group">
            <label for="discount">Скидка:</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ $order->discount }}" step="0.01" min="0" max="100">
        </div>

        <button type="submit" class="btn btn-primary">Обновить заказ</button>
        <a href="{{ route('orders.index') }}" class="btn btn-warning">Назад к списку заказов</a>
    </form>
</div>
@endsection

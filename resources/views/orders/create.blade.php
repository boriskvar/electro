@extends('home')

@section('content')
<div class="container">
    <h1>Создание нового заказа</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">Пользователь:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Выберите пользователя</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="order_number">Номер заказа:</label>
            <input type="text" class="form-control" id="order_number" name="order_number" value="{{ $orderNumber }}" readonly>
        </div>

        <div class="form-group">
            <label for="total_price">Общая цена:</label>
            <input type="number" class="form-control" id="total_price" name="total_price" required>
        </div>

        <div class="form-group">
            <label for="status">Статус заказа:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="выполнен">Выполнен</option>
                <option value="в процессе выполнения">В процессе выполнения</option>
                <option value="отменен">Отменен</option>
            </select>
        </div>

        <div class="form-group">
            <label for="shipping_address">Адрес доставки:</label>
            <input type="text" class="form-control" id="shipping_address" name="shipping_address">
        </div>

        <div class="form-group">
            <label for="order_date">Дата заказа:</label>
            <input type="date" class="form-control" id="order_date" name="order_date" required>
        </div>

        <div class="form-group">
            <label for="delivery_date">Дата доставки:</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date">
        </div>

        <div class="form-group">
            <label for="payment_method">Метод оплаты:</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="предоплата">Предоплата</option>
                <option value="при получении">При получении</option>
            </select>
        </div>

        <div class="form-group">
            <label for="shipping_status">Доставка:</label>
            <select class="form-control" id="shipping_status" name="shipping_status">
                <option value="курьером">Курьером</option>
                <option value="почтой">Почтой</option>
                <option value="самовывоз">Самовывоз</option>
            </select>
        </div>

        <div class="form-group">
            <label for="discount">Скидка:</label>
            <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0" max="100" placeholder="Введите код скидки">
        </div>

        <button type="submit" class="btn btn-primary">Создать заказ</button>
        <a href="{{ route('orders.index') }}" class="btn btn-warning">Назад к списку заказов</a>
    </form>
</div>
@endsection

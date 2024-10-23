@extends('home')

@section('content')
<div class="container">
    <h1>Создание нового заказа</h1>
    <form action="{{ route('orders.store') }}" method="POST" id="order-form">
        @csrf

        <!-- Поле выбора пользователя -->
        <div class="form-group">
            <label for="user_id">Пользователь:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Выберите пользователя</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <!-- Номер заказа -->
        <div class="form-group">
            <label for="order_number">Номер заказа:</label>
            <input type="text" class="form-control" id="order_number" name="order_number" value="{{ $orderNumber }}" readonly>
        </div>

        <!-- Общая цена -->
        <div class="form-group">
            <label for="total_price">Общая цена:</label>
            <input type="number" class="form-control" id="total_price" name="total_price" required>
        </div>

        <!-- Статус заказа -->
        <div class="form-group">
            <label for="status">Статус заказа:</label>
            <select class="form-control" id="status" name="status" required>
                <option value="выполнен">Выполнен</option>
                <option value="в процессе выполнения">В процессе выполнения</option>
                <option value="отменен">Отменен</option>
            </select>
        </div>

        <!-- Дата заказа -->
        <div class="form-group">
            <label for="order_date">Дата заказа:</label>
            <input type="date" class="form-control" id="order_date" name="order_date" required>
        </div>

        <!-- Адрес доставки -->
        <div class="form-group">
            <label for="shipping_address">Адрес доставки:</label>
            <input type="text" class="form-control" id="shipping_address" name="shipping_address">
        </div>

        <!-- Дата доставки -->
        <div class="form-group">
            <label for="delivery_date">Дата доставки:</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date">
        </div>

        <!-- Варианты доставки -->
        <div class="form-group">
            <label for="shipping_status">Варианты доставки:</label>
            <select class="form-control" id="shipping_status" name="shipping_status">
                <option value="курьером">Курьером</option>
                <option value="почтой">Почтой</option>
                <option value="самовывоз">Самовывоз</option>
            </select>
        </div>

        <!-- Метод оплаты -->
        <div class="form-group">
            <label for="payment_method">Метод оплаты:</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="предоплата">Предоплата</option>
                <option value="при получении">При получении</option>
            </select>
        </div>

        <!-- Скидка -->
        <div class="form-group">
            <label for="discount">Скидка:</label>
            <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0" max="100">
        </div>

        <!-- Tекст -->
        <div class="form-group">
            <label for="order_notes">Описание заказа</label>
            <input type="text" class="form-control" id="order_notes" name="order_notes">
        </div>

        <!-- Выбор товаров -->
        <h3>Выберите товары:</h3>
        @foreach ($products as $product)
        <div class="form-group">
            <label>
                <input type="checkbox" name="order_items[{{ $product->id }}][product_id]" value="{{ $product->id }}">
                {{ $product->name }} ({{ $product->price }} $)
            </label>
            <input type="number" name="order_items[{{ $product->id }}][quantity]" min="1" value="1" style="width: 60px;">
            <input type="hidden" name="order_items[{{ $product->id }}][price]" value="{{ $product->price }}">
            @php
            $images = json_decode($product->images, true);
            @endphp
            @if(!empty($images))
            <img src="{{ Storage::url($images[0]) }}" alt="{{ $product->name }}" width="100">
            @endif
        </div>
        @endforeach


        <button type="submit" class="btn btn-primary">Создать заказ</button>
        <a href="{{ route('orders.index') }}" class="btn btn-warning">Назад к списку заказов</a>
    </form>
</div>

<script>
    document.getElementById('order-form').addEventListener('submit', function(event) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="order_items"]:checked');
        if (checkboxes.length === 0) {
            event.preventDefault();
            alert('Вы должны выбрать хотя бы один товар для заказа.');
        }
    });

</script>

@endsection

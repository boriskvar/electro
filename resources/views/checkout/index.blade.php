@extends('home')

@section('content')
<div class="container">
    <h1>Оформление заказа</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="shipping_address">Адрес доставки</label>
            <input type="text" name="shipping_address" id="shipping_address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Метод оплаты</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="cash">Наличными</option>
                <option value="credit_card">Кредитной картой</option>
                <!-- Добавьте другие методы оплаты по необходимости -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
    </form>
</div>
@endsection

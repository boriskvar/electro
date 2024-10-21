@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Оформление заказа</h1>

    <div class="alert alert-success">
        Ваш заказ успешно оформлен!
    </div>

    <p>Спасибо за покупку. Мы свяжемся с вами для подтверждения.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Вернуться к покупкам</a>
</div>
@endsection

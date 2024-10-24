@extends('home')

@section('content')
<div class="container">
    <h1>Добавление товара в корзину</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @else
    <div class="alert alert-danger">
        Произошла ошибка при добавлении товара в корзину.
    </div>
    @endif

    <a href="{{ route('cart.index') }}" class="btn btn-primary">Перейти к корзине</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Продолжить покупки</a>
</div>
@endsection

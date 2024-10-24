@extends('home')

@section('content')
<div class="container">
    <h1>Удаление товара из корзины</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @else
    <div class="alert alert-danger">
        Произошла ошибка при удалении товара из корзины.
    </div>
    @endif

    <a href="{{ route('cart.index') }}" class="btn btn-primary">Вернуться к корзине</a>
</div>
@endsection

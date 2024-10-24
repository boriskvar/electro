@extends('home')

@section('content')
<div class="container">
    <h1>Обновление количества товара</h1>

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

    <div class="card">
        <div class="card-body">
            <p>Количество товара было успешно обновлено.</p>
            <p><strong>Товар:</strong> {{ $product->name }}</p>
            <p><strong>Новое количество:</strong> {{ $newQuantity }}</p>
        </div>
    </div>

    <a href="{{ route('cart.index') }}" class="btn btn-primary mt-3">Вернуться к корзине</a>
</div>
@endsection

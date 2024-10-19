@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Добро пожаловать в наш магазин</h1>

    <div class="container">
        <h2>Категории</h2>
        @yield('categories')
    </div>

    <div class="container">
        <h2>Продукты</h2>
        @yield('products')
    </div>

</div>
@endsection

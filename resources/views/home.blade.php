@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Добро пожаловать в наш магазин</h1>
    <h2>Популярные товары</h2>
    <!-- SECTION -->
    <div class="container">
        @yield('categories')
    </div>
    <!-- /SECTION -->
</div>
@endsection

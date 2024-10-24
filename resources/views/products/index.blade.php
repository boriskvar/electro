@extends('home')

@section('content')
{{-- {{ dd($products->toArray()) }} --}}
<a href="{{ route('cart.index') }}" class="btn btn-success">Перейти в корзину</a>

<div class="container">
    <h1>Список товаров</h1>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить товар</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @if($products->isNotEmpty())
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
                <td>
                    <!-- Кнопка для перехода к отзывам -->
                    <a href="{{ route('reviews.index', $product->id) }}" class="btn btn-info">Просмотреть отзывы</a>
                </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Нет доступных товаров.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection

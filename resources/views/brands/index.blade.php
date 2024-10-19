@extends('home')

@section('content')
<div class="container">
    <h1>Список брендов</h1>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('brands.create') }}" class="btn btn-primary">Добавить бренд</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @if($brands->isNotEmpty())
            @foreach($brands as $brand)
            <tr>
                <td>{{ $brand->id }}</td>
                <td><a href="{{ route('brands.show', $brand->id) }}">{{ $brand->name }}</a></td>
                <td>
                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот бренд?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">Нет доступных брендов.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection

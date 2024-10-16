@extends('home')

@section('content')
{{-- {{ dd($categories->toArray()) }} --}}
<div class="container">
    <h1>Список категорий</h1>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Добавить категорию</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                {{-- <td>{{ $category->name }}</td> --}}
                <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                <td>
                    @if($category->children->count())
                    <ul>
                        @foreach($category->children as $child)
                        <li>{{ $child->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

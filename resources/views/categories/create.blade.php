@extends('home')

@section('content')
<div class="container">
    <h1>Добавить новую категорию</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Название категории:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>
        {{-- {{ dd($categories->toArray()) }} --}}
        <div class="form-group">
            <label for="parent_id">Родительская категория</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">Нет родительской категории</option>
                @if($categories->isNotEmpty())
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
                @else
                <option value="">Нет доступных категорий</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Создать категорию</button>
        <a href="{{ route('categories.index') }}" class="btn btn-warning"">Назад к списку категорий</a>
    </form>
</div>
@endsection

@extends('home')

@section('content')
<div class="container">
    <h1>Редактировать категорию: {{ $category->name }}</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Название категории:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="parent_id">Родительская категория:</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">Нет родительской категории</option>
                @foreach($categories as $cat)
                <!-- Скрываем редактируемую категорию -->
                @if ($cat->id !== $category->id)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endif
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('categories.index') }}" class="btn btn-warning">Назад к списку категорий</a>
    </form>
</div>
@endsection

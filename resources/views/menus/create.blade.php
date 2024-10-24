@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Добавить Меню</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Введите название" required>
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input type="url" class="form-control" id="url" name="url" placeholder="Введите URL (например, https://example.com)" required>
        </div>

        <div class="form-group">
            <label for="position">Позиция</label>
            <input type="number" class="form-control" id="position" name="position" placeholder="Введите позицию" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Родительское меню</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">Нет родителя</option>
                @foreach($parentMenus as $parentMenu)
                <option value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Активен</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1">Да</option>
                <option value="0">Нет</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Создать Меню</button>
        <a href="{{ route('menus.index') }}" class="btn btn-warning">Назад</a>
    </form>
</div>
@endsection

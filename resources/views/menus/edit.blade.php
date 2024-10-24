@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Редактировать Меню</h1>

    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $menu->url) }}" required>
        </div>

        <div class="form-group">
            <label for="position">Позиция</label>
            <input type="number" class="form-control" id="position" name="position" value="{{ $menu->position }}" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Родительское меню</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="">Нет родителя</option>
                @foreach($parentMenus as $parentMenu)
                <option value="{{ $parentMenu->id }}" {{ $menu->parent_id == $parentMenu->id ? 'selected' : '' }}>
                    {{ $parentMenu->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Активен</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" {{ $menu->is_active ? 'selected' : '' }}>Да</option>
                <option value="0" {{ !$menu->is_active ? 'selected' : '' }}>Нет</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Обновить Меню</button>
        <a href="{{ route('menus.index') }}" class="btn btn-warning">Назад</a>
    </form>
</div>
@endsection

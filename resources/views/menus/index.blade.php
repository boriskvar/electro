@extends('layouts.layout')
<!-- Используй свой основной шаблон -->

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Список Меню</h1>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <a href="{{ route('menus.create') }}" class="btn btn-primary">Добавить Меню</a>
    </div>

    @if ($menus->isEmpty())
    <p>Нет доступных меню.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>URL</th>
                <th>Активен</th>
                <th>Позиция</th>
                <th>Родитель</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $menu)
            <tr>
                <td>
                    <a href="{{ route('menus.show', $menu->id) }}">{{ $menu->name }}</a>
                </td>
                <td>{{ $menu->url }}</td>

                <td>
                    <span class="{{ $menu->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $menu->is_active ? 'Да' : 'Нет' }}
                    </span>
                </td>
                <td>{{ $menu->position }}</td>
                <td>{{ $menu->parent_id ? \App\Models\Menu::find($menu->parent_id)->name : 'Нет' }}</td> <!-- Отображаем родительский пункт -->

                <td>
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

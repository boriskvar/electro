@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>{{ $menu->name }}</h1>
    <p><strong>URL:</strong> <a href="{{ $menu->url }}" target="_blank">{{ $menu->url }}</a></p>
    <p><strong>Позиция:</strong> {{ $menu->position }}</p> <!-- Отображаем позицию -->
    <p><strong>Родитель:</strong> {{ $menu->parent_id ? \App\Models\Menu::find($menu->parent_id)->name : 'Нет' }}</p> <!-- Отображаем родительский пункт -->

    <a href="{{ route('menus.index') }}" class="btn btn-warning">Назад к меню</a>
</div>
@endsection

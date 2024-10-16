@extends('home')

@section('content')

<div class="container">
    {{-- {{ dd($category->toArray()) }} --}}
    <h1>Категория: {{ $category->name }}</h1>

    <div class="category-details">
        <p><strong>Slug:</strong> {{ $category->slug }}</p>
        <p><strong>Описание:</strong> {{ $category->description }}</p>
        <p><strong>Родительская категория:</strong> {{ $category->parent_id ? $category->parent->name : 'Нет родительской категории' }}</p>
    </div>

    <h2>Дочерние категории</h2>
    @if($category->children->isNotEmpty())
    <ul>
        @foreach($category->children as $child)
        <li><a href="{{ route('categories.show', $child->id) }}">{{ $child->name }}</a></li>
        @endforeach
    </ul>
    @else
    <p>Нет дочерних категорий.</p>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-warning">Назад к списку категорий</a>
</div>
@endsection

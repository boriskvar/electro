@extends('home')

@section('content')
<div class="container">
    <h1>Добавить новый товар</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Название товара:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="slug">Slug (уникальный идентификатор для SEO):</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="details">Детальная информация:</label>
            <textarea class="form-control" id="details" name="details" rows="4">{{ old('details') }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Цена:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="old_price">Старая цена:</label>
            <input type="number" class="form-control" id="old_price" name="old_price">
        </div>
        <div class="form-group">
            <label for="in_stock">В наличии:</label>
            <select class="form-control" id="in_stock" name="in_stock" required>
                <option value="1">Да</option>
                <option value="0">Нет</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rating">Рейтинг:</label>
            <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="5">
        </div>
        <div class="form-group">
            <label for="reviews_count">Количество отзывов:</label>
            <input type="number" class="form-control" id="reviews_count" name="reviews_count" min="0">
        </div>
        <div class="form-group">
            <label for="views_count">Количество просмотров:</label>
            <input type="number" class="form-control" id="views_count" name="views_count" min="0">
        </div>

        <div class="form-group">
            <label for="images">Загрузить изображения:</label>
            {{-- <input type="file" class="form-control" id="images" name="images[]" multiple> --}}
            <input type="file" class="form-control" id="images" name="images[]" multiple onchange="previewImages()">
        </div>


        <div class="form-group">
            <label for="colors">Цвета:</label>
            <input type="text" class="form-control" id="colors" name="colors[]" placeholder="Введите цвет">
            <input type="text" class="form-control" id="colors" name="colors[]" placeholder="Введите еще один цвет">
        </div>

        <div class="form-group">
            <label for="sizes">Размеры:</label>
            <input type="text" class="form-control" id="sizes" name="sizes[]" placeholder="Введите размер">
            <input type="text" class="form-control" id="sizes" name="sizes[]" placeholder="Введите еще один размер">
        </div>

        <div class="form-group">
            <label for="qty">Количество на складе:</label>
            <input type="number" class="form-control" id="qty" name="qty" min="0">
        </div>

        <div class="form-group">
            <label for="category_id">Категория:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Выберите категорию</option>
                @if ($categories->isNotEmpty())
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
                @else
                <option value="">Нет доступных категорий</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="brand_id">Бренд (необязательно):</label>
            <select class="form-control" id="brand_id" name="brand_id">
                <option value="">Выберите бренд (необязательно)</option>
                @if ($brands->isNotEmpty())
                @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
                @else
                <option value="">Нет доступных брендов</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Создать товар</button>
        <a href="{{ route('products.index') }}" class="btn btn-warning">Назад к списку товаров</a>
    </form>
</div>
<script>
    function previewImages() {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = ''; // Очищаем контейнер перед добавлением новых изображений
        const files = document.getElementById('images').files; // Получаем загруженные файлы

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result; // Устанавливаем источник изображения
                img.classList.add('img-thumbnail', 'me-2'); // Добавляем классы для стилизации
                img.style.maxWidth = '100px'; // Ограничиваем максимальную ширину
                img.style.maxHeight = '100px'; // Ограничиваем максимальную высоту
                previewContainer.appendChild(img); // Добавляем изображение в контейнер
            }

            reader.readAsDataURL(file); // Читаем файл как Data URL
        }
    }

</script>
@endsection

@extends('home')

@section('content')
<div class="container">
    <h1>Редактировать товар: {{ $product->name }}</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Указываем метод PUT для обновления -->

        <div class="form-group">
            <label for="name">Название товара:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="slug">Slug (уникальный идентификатор для SEO):</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ $product->slug }}" required>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="details">Детальная информация:</label>
            <textarea class="form-control" id="details" name="details" rows="4">{{ old('details', $product->details) }}</textarea>
        </div>
        <div class="form-group">
            <label for="price">Цена:</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        <div class="form-group">
            <label for="old_price">Старая цена:</label>
            <input type="number" class="form-control" id="old_price" name="old_price" value="{{ $product->old_price }}">
        </div>
        <div class="form-group">
            <label for="in_stock">В наличии:</label>
            <select class="form-control" id="in_stock" name="in_stock" required>
                <option value="1" {{ $product->in_stock ? 'selected' : '' }}>Да</option>
                <option value="0" {{ !$product->in_stock ? 'selected' : '' }}>Нет</option>
            </select>
        </div>
        <div class="form-group">
            <label for="rating">Рейтинг:</label>
            <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="5" value="{{ $product->rating }}">
        </div>
        <div class="form-group">
            <label for="reviews_count">Количество отзывов:</label>
            <input type="number" class="form-control" id="reviews_count" name="reviews_count" min="0" value="{{ $product->reviews_count }}">
        </div>
        <div class="form-group">
            <label for="views_count">Количество просмотров:</label>
            <input type="number" class="form-control" id="views_count" name="views_count" min="0" value="{{ $product->views_count }}">
        </div>

        <div class="form-group">
            <label for="images">Загрузить изображения:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple onchange="previewImages()">
        </div>

        <!-- предварительный просмотр изображений -->
        <div id="image-preview" class="mb-3"></div>

        <div class="form-group">
            <label for="colors">Цвета:</label>
            @foreach (json_decode($product->colors) as $color)
            <input type="text" class="form-control" name="colors[]" value="{{ $color }}" placeholder="Введите цвет">
            @endforeach
            <input type="text" class="form-control" name="colors[]" placeholder="Введите еще один цвет">
        </div>

        <div class="form-group">
            <label for="sizes">Размеры:</label>
            @foreach (json_decode($product->sizes) as $size)
            <input type="text" class="form-control" name="sizes[]" value="{{ $size }}" placeholder="Введите размер">
            @endforeach
            <input type="text" class="form-control" name="sizes[]" placeholder="Введите еще один размер">
        </div>

        <div class="form-group">
            <label for="qty">Количество на складе:</label>
            <input type="number" class="form-control" id="qty" name="qty" min="0" value="{{ $product->qty }}">
        </div>

        <div class="form-group">
            <label for="category_id">Категория:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Выберите категорию</option>
                @if ($categories->isNotEmpty())
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
                @else
                <option value="">Нет доступных брендов</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="is_top_selling">Топ продаж:</label>
            <select class="form-control" id="is_top_selling" name="is_top_selling" required>
                <option value="1" {{ $product->is_top_selling ? 'selected' : '' }}>Да</option>
                <option value="0" {{ !$product->is_top_selling ? 'selected' : '' }}>Нет</option>
            </select>
        </div>

        <div class="form-group">
            <label for="discount_percentage">Скидка (%):</label>
            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" placeholder="Введите процент скидки" value="{{ $product->discount_percentage }}">
        </div>

        <div class="form-group">
            <label for="is_new">Новинка:</label>
            <select class="form-control" id="is_new" name="is_new" required>
                <option value="1" {{ $product->is_new ? 'selected' : '' }}>Да</option>
                <option value="0" {{ !$product->is_new ? 'selected' : '' }}>Нет</option>
            </select>
        </div>

        <div class="form-group">
            <label for="position">Позиция:</label>
            <input type="number" class="form-control" id="position" name="position" placeholder="Введите позицию товара" value="{{ $product->position }}">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('products.index') }}" class="btn btn-warning">Назад к списку товаров</a>
    </form>
</div>

<script>
    function previewImages() {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = ''; // Очищаем предыдущий предварительный просмотр

        const files = document.getElementById('images').files; // Получаем файлы из поля ввода
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result; // Устанавливаем источник изображения
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '100px'; // Ограничиваем ширину изображения
                img.style.maxHeight = '100px'; // Ограничиваем высоту изображения
                preview.appendChild(img); // Добавляем изображение в контейнер
            }

            reader.readAsDataURL(file); // Читаем файл как URL
        }
    }

</script>

@endsection

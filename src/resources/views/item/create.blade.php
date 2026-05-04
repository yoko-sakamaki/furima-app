@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <h1 class="sell__title">商品の出品</h1>

    <form class="sell__form" action="/sell" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sell__section">
            <h3 class="sell__section-title">商品画像</h3>
            <div class="sell__image-upload">
                <label for="image" class="sell__image-label">
                    <div class="sell__image-preview" id="imagePreview">
                        <span class="sell__image-button">画像を選択する</span>
                    </div>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" hidden
                        onchange="previewImage(this)">
                </label>
                @error('image')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell__section">
            <h2 class="sell__section-title--large">商品の詳細</h2>

            <div class="sell__form-group">
                <label class="sell__label">カテゴリー</label>
                <div class="sell__categories">
                    @foreach($categories as $category)
                    <label class="sell__category-label">
                        <input type="checkbox" name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('categories')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__form-group">
                <label class="sell__label">商品の状態</label>
                <div class="sell__select-wrapper">
                    <select name="condition_id" class="sell__select">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}"
                            {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('condition_id')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="sell__section">
            <h2 class="sell__section-title--large">商品名と説明</h2>

            <div class="sell__form-group">
                <label class="sell__label">商品名</label>
                <input class="sell__input" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__form-group">
                <label class="sell__label">ブランド名</label>
                <input class="sell__input" type="text" name="brand" value="{{ old('brand') }}">
            </div>

            <div class="sell__form-group">
                <label class="sell__label">商品の説明</label>
                <textarea class="sell__textarea" name="description">{{ old('description') }}</textarea>
                @error('description')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__form-group">
                <label class="sell__label">販売価格</label>
                <div class="sell__price-input">
                    <span class="sell__price-symbol">¥</span>
                    <input class="sell__price-field" type="number" name="price" value="{{ old('price') }}" min="0">
                </div>
                @error('price')
                <p class="sell__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-primary">出品する</button>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
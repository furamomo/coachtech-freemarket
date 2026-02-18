@extends('layouts.app')

@section('head-title', '商品出品')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@section('content')
<div class="create__content">
    <div class="create__inner">

        <h1 class="create__title">商品の出品</h1>

        <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" class="create__form" novalidate>
            @csrf

            {{-- 商品画像 --}}
            <div class="create__field">
                <p class="create__field-title">商品画像</p>

                <div class="create__image">
                    <img src="" alt="" class="create__image-preview" id="itemImagePreview">

                    <input type="file" name="image" id="itemImageInput" class="create__image-input" accept="image/*"
                    >
                    <label for="itemImageInput" class="create__image-button">
                        画像を選択する
                    </label>
                </div>
                @if ($errors->has('image'))
                    <ul class="create-form__errors">
                        @foreach ($errors->get('image') as $error)
                            <li class="create-form__error-list">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- 商品の詳細 --}}
            <div class="create__group">
                <h2 class="create__group-title">商品の詳細</h2>

                {{-- カテゴリー --}}
                <div class="create__field">
                    <p class="create__field-title">カテゴリー</p>

                    <div class="create__categories">
                        @foreach($categories as $category)
                            <label class="create__category">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="create__category-input" {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
                                <span class="create__category-text">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    @if ($errors->has('category_ids'))
                        <ul class="create-form__errors">
                            @foreach ($errors->get('category_ids') as $error)
                                <li class="create-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- 商品の状態 --}}
                <div class="create__field">
                    <label for="condition" class="create__field-title">
                        商品の状態
                    </label>

                    <div class="create__select-wrapper">
                        <select name="condition" id="condition" class="create__select" required>
                            <option class="create__option create__option--default" value="" disabled {{ old('condition') ? '' : 'selected' }} hidden>
                                選択してください
                            </option>
                            @foreach($conditions as $key => $label)
                                <option class="create__option" value="{{ $key }}" {{ old('condition') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($errors->has('condition'))
                        <ul class="create-form__errors">
                            @foreach ($errors->get('condition') as $error)
                                <li class="create-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- 商品名と説明 --}}
            <div class="create__group">
                <h2 class="create__group-title">商品名と説明</h2>

                <div class="create__field">
                    <label for="name" class="create__field-title">商品名</label>
                    <input id="name" name="name" type="text" class="create__input" value="{{ old('name') }}">

                    @if ($errors->has('name'))
                        <ul class="create-form__errors">
                            @foreach ($errors->get('name') as $error)
                                <li class="create-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="create__field">
                    <label for="brand_name" class="create__field-title">ブランド名</label>
                    <input id="brand_name" name="brand_name" type="text" class="create__input" value="{{ old('brand_name') }}">
                </div>

                <div class="create__field">
                    <label for="description" class="create__field-title">商品の説明</label>
                    <textarea id="description" name="description" class="create__textarea">{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <ul class="create-form__errors">
                            @foreach ($errors->get('description') as $error)
                                <li class="create-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="create__field">
                    <label for="price" class="create__field-title">販売価格</label>
                    <div class="create__price">
                        <span class="create__price-mark">¥</span>
                        <input id="price" name="price" type="number" class="create__price-input" value="{{ old('price') }}">
                    </div>

                    @if ($errors->has('price'))
                        <ul class="create-form__errors">
                            @foreach ($errors->get('price') as $error)
                                <li class="create-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- 送信 --}}
            <div class="create__actions">
                <button type="submit" class="create__submit">
                    出品する
                </button>
            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/create.js') }}"></script>
@endsection

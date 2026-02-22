@extends('layouts.app')

@section('title', 'プロフィール登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
    <div class="edit-content">
        <div class="edit-inner">
            <h1 class="edit-title">
                プロフィール設定
            </h1>

            <form action="{{ route('profile.update') }}" class="edit-form" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="edit-form__group edit-form__group--image">
                    <img id="profilePreview" src="{{ $profile?->profile_image_path ? asset('storage/' . $profile->profile_image_path) : '' }}" alt="" class="edit-image">

                    <input type="file" name="profile_image" id="profileImageInput" class="edit-image__input" accept="image/*">

                    <label for="profileImageInput" class="edit-image__link">
                        画像を選択する
                    </label>
                </div>

                <div class="edit-form__group">
                    <label class="edit-form__label">
                        ユーザー名
                    </label>
                    <input type="text" class="edit-form__input u-input {{ $errors->has('name') ? 'is-error' : '' }}" name="name" value="{{ old('name', $user->name ?? '') }}">

                    @if ($errors->has('name'))
                        <ul class="edit-form__errors">
                            @foreach ($errors->get('name') as $error)
                                <li class="edit-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="edit-form__group">
                    <label class="edit-form__label">
                        郵便番号
                    </label>
                    <input type="text" class="edit-form__input u-input {{ $errors->has('postal_code') ? 'is-error' : '' }}" name="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}">

                    @if ($errors->has('postal_code'))
                        <ul class="edit-form__errors">
                            @foreach ($errors->get('postal_code') as $error)
                                <li class="edit-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="edit-form__group">
                    <label class="edit-form__label">
                        住所
                    </label>
                    <input type="text" class="edit-form__input u-input {{ $errors->has('address') ? 'is-error' : '' }}" name="address" value="{{ old('address', $profile->address ?? '') }}">

                    @if ($errors->has('address'))
                        <ul class="edit-form__errors">
                            @foreach ($errors->get('address') as $error)
                                <li class="edit-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="edit-form__group">
                    <label class="edit-form__label">
                        建物名
                    </label>
                    <input type="text" class="edit-form__input" name="building_name" value="{{ old('building_name', $profile->building_name ?? '') }}">
                </div>

                <div class="edit-form__actions">
                    <button class="edit-form__submit" type="submit">
                        更新する
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script src="{{ asset('js/profile.js') }}"></script>

@endsection
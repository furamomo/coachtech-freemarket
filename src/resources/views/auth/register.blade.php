@extends('layouts.app', ['hideHeaderSearch' => true, 'hideHeaderNav' => true])

@section('head-title', '会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register-content">
        <div class="register-inner">
            <h1 class="register-title">会員登録</h1>

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf

                {{-- ユーザー名 --}}
                <div class="register-form__group">
                    <label class="register-form__label">ユーザー名</label>
                    <input class="register-form__input" type="text" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <ul class="register-form__errors">
                            @foreach ($errors->get('name') as $error)
                                <li class="register-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- メールアドレス --}}
                <div class="register-form__group">
                    <label class="register-form__label">メールアドレス</label>
                    <input class="register-form__input" type="text" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <ul class="register-form__errors">
                            @foreach ($errors->get('email') as $error)
                                <li class="register-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- パスワード --}}
                <div class="register-form__group">
                    <label class="register-form__label">パスワード</label>
                    <input class="register-form__input" type="password" name="password">
                </div>

                {{-- 確認用パスワード --}}
                <div class="register-form__group">
                    <label class="register-form__label">確認用パスワード</label>
                    <input class="register-form__input" type="password" name="password_confirmation">

                    @if ($errors->has('password') || $errors->has('password_confirmation'))
                        <ul class="register-form__errors">
                            @foreach ($errors->get('password') as $error)
                                <li class="register-form__error-list">{{ $error }}

                                </li>
                            @endforeach

                            @foreach ($errors->get('password_confirmation') as $error)
                                <li class="register-form__error-list">{{ $error }}

                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="register-form__actions">
                    <button class="register-form__submit" type="submit">登録する</button>
                </div>

                <div class="register-form__link">
                    <a href="{{ route('login') }}" class="register-form__link-text">ログインはこちら</a>
                </div>
            </form>
        </div>
    </div>
@endsection

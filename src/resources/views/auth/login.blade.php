@extends('layouts.app', ['hideHeaderSearch' => true, 'hideHeaderNav' => true])


@section('head-title', 'ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login-content">
        <div class="login-inner">
            <h1 class="login-title">
                ログイン
            </h1>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                {{-- メールアドレス --}}
                <div class="login-form__group">
                    <label class="login-form__label">メールアドレス</label>
                    <input
                        class="login-form__input"
                        type="text"
                        name="email"
                        value="{{ old('email') }}"
                    >

                    @if ($errors->has('email'))
                        <ul class="login-form__errors">
                            @foreach ($errors->get('email') as $error)
                                <li class="login-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- パスワード --}}
                <div class="login-form__group">
                    <label class="login-form__label">パスワード</label>
                    <input
                        class="login-form__input"
                        type="password"
                        name="password"
                    >

                    @if ($errors->has('password'))
                        <ul class="login-form__errors">
                            @foreach ($errors->get('password') as $error)
                                <li class="login-form__error-list">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- ログイン失敗（認証エラー） --}}
                @if ($errors->has('login'))
                    <ul class="login-form__errors">
                        @foreach ($errors->get('auth') as $error)
                            <li class="login-form__error-list">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="login-form__actions">
                    <button class="login-form__submit" type="submit">
                        ログインする
                    </button>
                </div>

            </form>

            <div class="login-form__link">
                <a href="{{ route('register') }}" class="login-form__link-text">会員登録はこちら</a>
            </div>
        </div>
    </div>
@endsection

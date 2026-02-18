<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>@yield('head-title', 'COACHTECH')</title>

        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
        @yield('css')
    </head>

    <body>
        <header class="header">
            <div class="header__inner">
                <a href="{{ url('/') }}" class="header__logo">
                    <img
                    src="{{ asset('assets/images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH" class="header__logo-image">
                </a>

                <div class="header__search">
                    @if (empty($hideHeaderSearch))
                        <form action="{{ route('items.index') }}" method="GET" class="header__search-form">
                            @csrf
                            <input class="header__search-input" type="text" name="keyword" value="{{ $keyword ?? request('keyword') ?? ''}}" placeholder="なにをお探しですか？">

                            <input type="hidden" name="tab" value="{{ $tab ?? request('tab', 'recommend') }}">
                        </form>
                    @endif
                </div>

                <nav class="header__nav">
                    @if (empty($hideHeaderNav))
                        @auth
                            <form action="{{ route('logout')}}" method="POST" class="header__nav-form">
                                @csrf
                                <button type="submit" class="header__nav-button">
                                ログアウト
                                </button>
                            </form>

                            <a href="{{ route('mypage.show') }}" class="header__nav-link">
                                マイページ
                            </a>

                            <a href="{{route('sell.create')}}" class="header__nav-link header__nav-link--primary">
                                出品
                            </a>
                        @endauth

                        @guest
                            {{-- 未ログイン --}}
                            <a href="{{ route('login') }}" class="header__nav-link">
                                ログイン
                            </a>

                            <a href="{{ route('register') }}" class="header__nav-link header__nav-link--primary">
                                会員登録
                            </a>
                        @endguest
                    @endif
                </nav>

            </div>
        </header>

        <main class="main">
            @yield('content')
        </main>
    </body>
</html>

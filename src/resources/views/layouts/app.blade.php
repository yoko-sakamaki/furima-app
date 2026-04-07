<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <a class="header__logo" href="/">
            <img src="{{ asset('img/logo.svg') }}" alt="COACHTECH">
        </a>

        <div class="header__search">
            <form action="/" method="GET">
                <input type="text" name="search"
                    placeholder="なにをお探しですか？"
                    value="{{ request('search') }}">
            </form>
        </div>

        <nav class="header__nav">
            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button class="header__nav-button" type="submit">ログアウト</button>
                </form>
                <a class="header__nav-link" href="/mypage">マイページ</a>
            @else
                <a class="header__nav-link" href="/login">ログイン</a>
                <a class="header__nav-link" href="/register">会員登録</a>
            @endauth
            <a href="/sell">
                <button class="btn-sell">出品</button>
            </a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
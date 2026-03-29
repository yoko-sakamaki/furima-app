@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <h1 class="auth__title">ログイン</h1>

    <form class="auth__form" action="/login" method="POST">
        @csrf

        <div class="auth__form-group">
            <label class="auth__label">メールアドレス</label>
            <input
                class="auth__input"
                type="email"
                name="email"
                value="{{ old('email') }}"
            >
            @error('email')
                <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__form-group">
            <label class="auth__label">パスワード</label>
            <input
                class="auth__input"
                type="password"
                name="password"
            >
            @error('password')
                <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        @if(session('status') == 'failed' || $errors->has('email'))
            <p class="auth__error">ログイン情報が登録されていません</p>
        @endif

        <button class="btn-primary" type="submit">ログインする</button>
    </form>

    <p class="auth__link">
        <a class="text-link" href="/register">会員登録はこちら</a>
    </p>
</div>
@endsection
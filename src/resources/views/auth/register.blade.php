@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <h1 class="auth__title">会員登録</h1>

    <form class="auth__form" action="/register" method="POST">
        @csrf

        <div class="auth__form-group">
            <label class="auth__label">ユーザー名</label>
            <input
                class="auth__input"
                type="text"
                name="name"
                value="{{ old('name') }}">
            @error('name')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__form-group">
            <label class="auth__label">メールアドレス</label>
            <input
                class="auth__input"
                type="email"
                name="email"
                value="{{ old('email') }}">
            @error('email')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__form-group">
            <label class="auth__label">パスワード</label>
            <input
                class="auth__input"
                type="password"
                name="password">
            @error('password')
            <p class="auth__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth__form-group">
            <label class="auth__label">確認用パスワード</label>
            <input
                class="auth__input"
                type="password"
                name="password_confirmation">
        </div>

        <button class="btn-primary" type="submit">登録する</button>
    </form>

    <p class="auth__link">
        <a class="text-link" href="/login">ログインはこちら</a>
    </p>
</div>
@endsection
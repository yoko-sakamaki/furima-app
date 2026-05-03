@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">ログイン</h1>

    <form action="/login" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input class="form-input" type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">パスワード</label>
            <input class="form-input" type="password" name="password">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        @if(session('status') == 'failed' || $errors->has('email'))
            <p class="form-error">ログイン情報が登録されていません</p>
        @endif

        <button class="btn-primary" type="submit">ログインする</button>
    </form>

    <p class="auth__link">
        <a class="text-link" href="/register">会員登録はこちら</a>
    </p>
</div>
@endsection
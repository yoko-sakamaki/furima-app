@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile">
    <h1 class="profile__title">プロフィール設定</h1>

    <form class="profile__form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="profile__image-group">
            <div class="profile__image-preview">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
                @else
                    <div class="profile__image-placeholder"></div>
                @endif
            </div>
            <label class="btn-image" for="profile_image">画像を選択する</label>
            <input type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png" hidden>
        </div>

        <div class="profile__form-group">
            <label class="profile__label">ユーザー名</label>
            <input class="profile__input" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="profile__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__form-group">
            <label class="profile__label">郵便番号</label>
            <input class="profile__input" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <p class="profile__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__form-group">
            <label class="profile__label">住所</label>
            <input class="profile__input" type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <p class="profile__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile__form-group">
            <label class="profile__label">建物名</label>
            <input class="profile__input" type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button class="btn-primary" type="submit">更新する</button>
    </form>
</div>
@endsection
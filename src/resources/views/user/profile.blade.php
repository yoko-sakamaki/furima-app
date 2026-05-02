@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">プロフィール設定</h1>

    <form action="/mypage/profile" method="POST" enctype="multipart/form-data">
        @csrf

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

        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input class="form-input" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input class="form-input" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">住所</label>
            <input class="form-input" type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">建物名</label>
            <input class="form-input" type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button class="btn-primary" type="submit">更新する</button>
    </form>
</div>
@endsection
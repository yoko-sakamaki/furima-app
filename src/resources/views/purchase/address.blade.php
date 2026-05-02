@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <h1 class="purchase__title">住所の変更</h1>

    <form action="/purchase/address/{{ $item_id }}" method="POST">
        @csrf

        <div class="purchase__form-group">
            <label class="purchase__label">郵便番号</label>
            <input class="purchase__input" type="text" name="postal_code"
                value="{{ old('postal_code', $address->postal_code ?? '') }}"
                placeholder="123-4567">
            @error('postal_code')
                <p class="purchase__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="purchase__form-group">
            <label class="purchase__label">住所</label>
            <input class="purchase__input" type="text" name="address"
                value="{{ old('address', $address->address ?? '') }}">
            @error('address')
                <p class="purchase__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="purchase__form-group">
            <label class="purchase__label">建物名</label>
            <input class="purchase__input" type="text" name="building"
                value="{{ old('building', $address->building ?? '') }}">
        </div>

        <button type="submit" class="btn-primary">更新する</button>
    </form>
</div>
@endsection
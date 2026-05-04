@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">住所の変更</h1>

    <form action="/purchase/address/{{ $item_id }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input class="form-input" type="text" name="postal_code"
                value="{{ old('postal_code', $address->postal_code ?? '') }}"
                placeholder="123-4567">
            @error('postal_code')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">住所</label>
            <input class="form-input" type="text" name="address"
                value="{{ old('address', $address->address ?? '') }}">
            @error('address')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">建物名</label>
            <input class="form-input" type="text" name="building"
                value="{{ old('building', $address->building ?? '') }}">
        </div>

        <button type="submit" class="btn-primary">更新する</button>
    </form>
</div>
@endsection
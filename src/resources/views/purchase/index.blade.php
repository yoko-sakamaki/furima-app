@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="/purchase/{{ $item->id }}" method="POST">
        @csrf
        <div class="purchase__layout">
            <div class="purchase__left">
                <div class="purchase__item">
                    <div class="purchase__item-image">
                        <img src="{{ $item->image && !str_starts_with($item->image, 'http') ? asset('storage/' . $item->image) : $item->image }}" alt="{{ $item->name }}">
                    </div>
                    <div class="purchase__item-info">
                        <p class="purchase__item-name">{{ $item->name }}</p>
                        <p class="purchase__item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
                <div class="purchase__section">
                    <h2 class="purchase__section-title">支払い方法</h2>
                    <div class="purchase__select-wrapper">
                        <select name="payment_method" class="purchase__select" id="paymentSelect">
                            <option value="">選択してください</option>
                            <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                            <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>カード払い</option>
                        </select>
                    </div>
                    @error('payment_method')
                        <p class="purchase__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="purchase__section">
                    <div class="purchase__section-header">
                        <h2 class="purchase__section-title">配送先</h2>
                        <a href="/purchase/address/{{ $item->id }}" class="purchase__address-link">変更する</a>
                    </div>
                    @if($address)
                        <div class="purchase__address">
                            <p>〒{{ $address->postal_code }}</p>
                            <p>{{ $address->address }}</p>
                            @if($address->building)
                                <p>{{ $address->building }}</p>
                            @endif
                        </div>
                    @else
                        <p class="purchase__no-address">配送先が登録されていません</p>
                        <a href="/purchase/address/{{ $item->id }}" class="purchase__address-link">住所を登録する</a>
                    @endif
                </div>
            </div>
            <div class="purchase__right">
                <div class="purchase__summary">
                    <div class="purchase__summary-row">
                        <span>商品代金</span>
                        <p>¥{{ number_format($item->price) }}</p>
                    </div>
                    <div class="purchase__summary-row">
                        <span>支払い方法</span>
                        <p id="paymentMethodLabel">-</p>
                    </div>
                </div>
                <button type="submit" class="btn-primary">購入する</button>
            </div>
        </div>
    </form>
</div>

<script>
const select = document.getElementById('paymentSelect');
const label = document.getElementById('paymentMethodLabel');
const options = {
    'convenience': 'コンビニ払い',
    'card': 'カード払い'
};
select.addEventListener('change', function() {
    label.textContent = options[this.value] || '-';
});
</script>
@endsection
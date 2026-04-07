@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__profile">
        <div class="mypage__profile-image">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
            @else
                <div class="mypage__profile-placeholder"></div>
            @endif
        </div>
        <div class="mypage__profile-info">
            <h1 class="mypage__name">{{ $user->name }}</h1>
            <a href="/mypage/profile" class="btn-outline">プロフィールを編集</a>
        </div>
    </div>

    <div class="mypage__tabs">
        <a class="mypage__tab {{ request('page') !== 'buy' ? 'mypage__tab--active' : '' }}"
            href="/mypage?page=sell">出品した商品</a>
        <a class="mypage__tab {{ request('page') === 'buy' ? 'mypage__tab--active' : '' }}"
            href="/mypage?page=buy">購入した商品</a>
    </div>

    <div class="item-list__grid">
        @if(request('page') === 'buy')
            @foreach($purchasedItems as $purchase)
                <a class="item-card" href="/item/{{ $purchase->item->id }}">
                    <div class="item-card__image">
                        <img src="{{ $purchase->item->image }}" alt="{{ $purchase->item->name }}">
                    </div>
                    <p class="item-card__name">{{ $purchase->item->name }}</p>
                </a>
            @endforeach
        @else
            @foreach($sellingItems as $item)
                <a class="item-card" href="/item/{{ $item->id }}">
                    <div class="item-card__image">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @endforeach
        @endif
    </div>
</div>
@endsection
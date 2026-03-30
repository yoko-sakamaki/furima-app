@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item-list">
    <div class="item-list__tabs">
        <a class="item-list__tab {{ request('tab') !== 'mylist' ? 'item-list__tab--active' : '' }}"
            href="/?search={{ request('search') }}">おすすめ</a>
        <a class="item-list__tab {{ request('tab') === 'mylist' ? 'item-list__tab--active' : '' }}"
            href="/?tab=mylist&search={{ request('search') }}">マイリスト</a>
    </div>

    <div class="item-list__grid">
        @foreach($items as $item)
        <a class="item-card" href="/item/{{ $item->id }}">
            <div class="item-card__image">
                <img src="{{ $item->image }}" alt="{{ $item->name }}">
                @if($item->is_sold)
                    <span class="item-card__sold">Sold</span>
                @endif
            </div>
            <p class="item-card__name">{{ $item->name }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
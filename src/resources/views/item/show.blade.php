@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-detail.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__main">
        <div class="item-detail__image">
            <img src="{{ $item->image && !str_starts_with($item->image, 'http') ? asset('storage/' . $item->image) : $item->image }}" alt="{{ $item->name }}">
        </div>

        <div class="item-detail__info">
            <h1 class="item-detail__name">{{ $item->name }}</h1>
            <p class="item-detail__brand">{{ $item->brand }}</p>
            <p class="item-detail__price"><span>¥</span>{{ number_format($item->price) }}<span>（税込）</span></p>

            <div class="item-detail__actions">
                <div class="item-detail__like">
                    @auth
                    <form action="/like/{{ $item->id }}" method="POST">
                        @csrf
                        <button type="submit" class="like-button">
                            <img src="{{ asset($isLiked ? 'img/icon-heart-pink.svg' : 'img/icon-heart.svg') }}" alt="いいね">
                        </button>
                    </form>
                    @else
                    <img src="{{ asset('img/icon-heart.svg') }}" alt="いいね">
                    @endauth
                    <span>{{ $item->likes->count() }}</span>
                </div>

                <div class="item-detail__comment-count">
                    <img src="{{ asset('img/icon-comment.svg') }}" alt="コメント">
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            <div class="item-detail__purchase">
                @if(!$item->is_sold)
                @auth
                @if(auth()->id() !== $item->user_id)
                <a href="/purchase/{{ $item->id }}" class="btn-primary">購入手続きへ</a>
                @endif
                @else
                <a href="/login" class="btn-primary">購入手続きへ</a>
                @endauth
                @else
                <button class="btn-primary" disabled style="opacity:0.5;">売り切れ</button>
                @endif
            </div>

            <div class="item-detail__description">
                <h2>商品説明</h2>
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-detail__meta">
                <h2>商品の情報</h2>
                <div class="item-detail__meta-row">
                    <span class="item-detail__meta-label">カテゴリー</span>
                    <div class="item-detail__categories">
                        @foreach($item->categories as $category)
                        <span class="item-detail__category">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="item-detail__meta-row">
                    <span class="item-detail__meta-label">商品の状態</span>
                    <span>{{ $item->condition->name }}</span>
                </div>
            </div>

            <div class="item-detail__comments">
                <h2>コメント({{ $item->comments->count() }})</h2>

                @foreach($item->comments as $comment)
                <div class="comment">
                    <div class="comment__user">
                        @if($comment->user->profile_image)
                        <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}">
                        @else
                        <div class="comment__avatar"></div>
                        @endif
                        <span class="comment__name">{{ $comment->user->name }}</span>
                    </div>
                    <p class="comment__body">{{ $comment->body }}</p>
                </div>
                @endforeach

                <div class="item-detail__comment-form">
                    <h2>商品へのコメント</h2>
                    @auth
                    <form action="/comment/{{ $item->id }}" method="POST">
                        @csrf
                        <textarea name="body" class="comment__input" placeholder="コメントを入力してください"></textarea>
                        @error('body')
                        <p class="comment__error">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="btn-primary">コメントを送信する</button>
                    </form>
                    @else
                    <form action="/login" method="GET">
                        <textarea name="body" class="comment__input" placeholder="コメントを入力してください"></textarea>
                        <button type="submit" class="btn-primary">コメントを送信する</button>
                    </form>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
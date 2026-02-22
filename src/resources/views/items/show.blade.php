@extends('layouts.app')

@section('head-title', '商品詳細')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')

<div class="show__content">
    <div class="show__inner">

        <div class="show__left">
            <div class="show__image">
                <img src="{{ $item->image_url }}" alt="商品画像" class="show__image-img">
            </div>
        </div>

        <div class="show__right">

            <h1 class="show__name">{{ $item->name }}</h1>

            @if(!empty($item->brand_name))
                <p class="show__brand">{{ $item->brand_name }}</p>
            @endif

            <p class="show__price">
                <span class="show__price-yen">¥</span>{{ number_format($item->price) }}
                <span class="show__price-tax">(税込)</span>
            </p>

            <div class="show__counts">
                <div class="show__count">
                    @if($canLike)
                        <form action="{{ route('items.like', $item) }}" method="POST">
                            @csrf
                            <button type="submit" class="show__like-button" aria-label="いいね">
                                @if($isLiked)
                                    <img class="show__like-img" src="{{ asset('assets/images/ハートロゴ_ピンク.png') }}" alt="いいね済み">
                                @else
                                    <img class="show__like-img" src="{{ asset('assets/images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                                @endif
                            </button>
                        </form>
                    @else
                        <span class="show__like-button is-disabled" aria-label="いいね（自分の商品）">
                            <img class="show__like-img" src="{{ asset('assets/images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                        </span>
                    @endif

                    <span class="show__count-number">{{ $likesCount }}</span>
                </div>

                <div class="show__count">
                    <img class="show__count-img" src="{{ asset('assets/images/ふきだしロゴ.png') }}" alt="コメント" class="show__icon"/>

                    <span class="show__count-number">{{ $item->comments->count() }}</span>
                </div>
            </div>


            <div class="show__purchase">
                @if($item->is_sold)
                    <p class="show__purchase-sold">SOLD</p>
                @elseif($canPurchase)
                    <a href="{{ route('purchase.create', $item) }}" class="show__purchase-button">
                        購入手続きへ
                    </a>
                @elseif(!auth()->check())
                    <a href="{{ route('purchase.create', ['item' => $item->id]) }}" class="show__purchase-button">
                        ログインして購入する
                    </a>
                @endif
            </div>


            <div class="show__section">
                <h2 class="show__section-title">商品説明</h2>
                <p class="show__description">{{ $item->description }}</p>
            </div>

            <div class="show__section">
                <h2 class="show__section-title">商品の情報</h2>

                <div class="show__info">
                    <p class="show__info-title">カテゴリー</p>
                    <div class="show__tags">
                        @foreach($item->categories as $category)
                            <span class="show__tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="show__info">
                    <p class="show__info-title">商品の状態</p>
                    <p class="show__info-value">
                        {{ $item->condition_label }}
                    </p>
                </div>
            </div>

            <div class="show__section">
                <h2 class="show__section-title">コメント（{{ $item->comments->count() }}）</h2>

                <div class="show__comment-area">
                    <div class="show__comments">
                        @forelse($item->comments as $comment)
                            <div class="show__comment">
                                <div class="show__comment-user">
                                    <div class="show__avatar">
                                        @if($comment->user->profile && $comment->user->profile->profile_image_path)
                                            <img src="{{ asset('storage/' . $comment->user->profile->profile_image_path) }}" alt="" class="show__avatar-img">
                                        @endif
                                    </div>
                                    <p class="show__username">{{ $comment->user->name }}</p>

                                    @auth
                                        @if ($comment->isBy(auth()->user()) && $comment->isSellerOf($item))
                                            <span class="show__badge">あなた (出品者)</span>
                                        @elseif ($comment->isBy(auth()->user()))
                                            <span class="show__badge">あなた</span>
                                        @elseif ($comment->isSellerOf($item))
                                            <span class="show__badge">出品者</span>
                                        @endif
                                    @endauth

                                </div>
                                <p class="show__comment-body">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="show__no-comment">まだコメントはありません</p>
                        @endforelse
                    </div>

                    <div class="show__post">
                        <p class="show__post-title">商品へのコメント</p>

                        <form action="{{ route('items.comments.store', $item) }}" method="POST" class="show__form">
                            @csrf
                            <textarea name="content" class="show__textarea u-input {{ $errors->has('content') ? 'is-error' : '' }}">{{ old('content') }}</textarea>

                            @if ($errors->has('content'))
                                <ul class="show-form__errors">
                                    @foreach ($errors->get('content') as $error)
                                        <li class="show-form__error-list">
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <button type="submit" class="show__submit">コメントを送信する</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

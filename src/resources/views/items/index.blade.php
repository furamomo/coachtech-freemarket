@extends('layouts.app')

@section('head-title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
    <div class="index-content">
        <div class="index-inner">

            <div class="index-menu-wrapper">
                <div class="index-menu">
                {{-- おすすめ --}}
                    <div class="index-menu__link">
                        <a href="{{ route('items.index', ['keyword' => $keyword ?? request('keyword')]) }}" class="index-menu__link-text {{ request('tab') === 'mylist' ? 'is-inactive is-recommend' : 'is-active is-recommend' }}">
                            おすすめ
                        </a>
                    </div>

                {{-- マイリスト --}}
                    <div class="index-menu__link">
                        <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => $keyword ?? request('keyword')]) }}" class="index-menu__link-text {{ request('tab') === 'mylist' ? 'is-active is-like' : 'is-inactive is-like' }}">
                            マイリスト
                        </a>
                    </div>
                </div>
            </div>

            <div class="index-items">
                @foreach($items as $item)
                    <a href="{{ route('items.show', $item) }}" class="index-items__card-link">
                        <div class="index-items__card">
                            <div class="index-items__card-image {{ $item->is_sold ? 'is-sold' : '' }}">
                                @if($item->is_sold)
                                    <div class="index-items__sold">
                                        <span class="index-items__sold-text">SOLD</span>
                                    </div>
                                @endif

                                <img src="{{ $item->image_url }}" alt="商品画像" class="index-items__card-image-img">
                            </div>

                            <p class="index-items__card-text">
                                {{$item->name}}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
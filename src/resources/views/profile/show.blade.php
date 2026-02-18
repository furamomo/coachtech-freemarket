@extends('layouts.app')

@section('title', 'プロフィール画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
    <div class="profile-show__content">
        <div class="profile-show__inner">

            <div class="profile-show__header">
                <div class="profile-show__user">
                    <img src="{{ $user->profile && $user->profile->profile_image_path ? asset('storage/' . $user->profile->profile_image_path) : asset('images/default-avatar.png') }}" alt="" class="profile-show__avatar">

                    <p class="profile-show__name">
                        {{$user->name}}
                    </p>
                </div>

                <div class="profile-show__action">
                    <a href="{{ route('profile.edit') }}" class="profile-show__link">
                        プロフィールを編集
                    </a>
                </div>
            </div>

            <div class="profile-show__menu-wrapper">
                <div class="profile-show__menu">
                    {{-- 出品した商品 --}}
                    <div class="profile-show__tab-link">
                        <a href="{{ url('/mypage') }}?page=sell" class="profile-show__tab-text is-sell {{ request('page', 'sell') === 'sell' ? 'is-active' : 'is-inactive' }}">
                            出品した商品
                        </a>
                    </div>

                    {{-- 購入した商品 --}}
                    <div class="profile-show__tab-link">
                        <a href="{{ url('/mypage') }}?page=buy" class="profile-show__tab-text is-buy {{ request('page') === 'buy' ? 'is-active' : 'is-inactive' }}">
                            購入した商品
                        </a>
                    </div>
                </div>
            </div>

            <div class="profile-show__items">
                @foreach($items as $item)
                    <a href="{{ $page === 'sell' ? route('items.show', $item) : route('items.show', $item)}}" class="profile-show__items-link">
                        <div class="profile-show__card">
                            <div class="profile-show__card-image {{ $item->is_sold ? 'is-sold' : '' }}">
                                @if($page === 'sell' && $item->is_sold)
                                    <div class="profile-show__sold">
                                        <span class="profile-show__sold-text">SOLD</span>
                                    </div>
                                @endif

                                <img src="{{ $item->image_url }}" alt="商品画像" class="profile-show__items-img">
                            </div>

                            <p class="profile-show__items-name">
                                {{$item->name}}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
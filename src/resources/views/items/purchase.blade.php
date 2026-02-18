@extends('layouts.app')

@section('head-title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/purchase.css') }}">
@endsection

@section('content')

<div class="purchase__content">
    <div class="purchase__inner">

        <form action="{{ route('purchase.checkout', $item) }}" method="POST" class="purchase__form" novalidate>
            @csrf

            <div class="purchase__left">
                <div class="purchase__detail">
                    <div class="purchase__image">
                        <img src="{{ $item->image_url }}" alt="商品画像" class="purchase__image-img">
                    </div>

                    <div class="purchase__item">
                        <h1 class="purchase__name">{{ $item->name }}</h1>

                        <p class="purchase__price">
                            <span class="purchase__price-yen">¥</span>{{ number_format($item->price) }}
                        </p>
                    </div>
                </div>

                <div class="purchase__group">
                    <h2 class="purchase__group-title">支払い方法</h2>

                    <div class="purchase__select-wrapper">
                        <select name="payment_method" id="payment_method" class="purchase__select" required>
                            <option class="purchase__option purchase__option--default" value="" disabled {{ $selectedPaymentMethod ? '' : 'selected' }} hidden>
                                選択してください
                            </option>
                            <option class="purchase__option" value="1" {{ $selectedPaymentMethod === '1' ? 'selected' : '' }}>
                                コンビニ支払い
                            </option>
                            <option class="purchase__option" value="2" {{ $selectedPaymentMethod === '2' ? 'selected' : '' }}>
                                カード支払い
                            </option>
                        </select>
                    </div>

                    @if ($errors->has('payment_method'))
                        <ul class="purchase__errors">
                            @foreach ($errors->get('payment_method') as $error)
                                <li class="purchase__error">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="purchase__group">
                    <div class="purchase__group-header">
                        <h2 class="purchase__group-title">配送先</h2>

                        <a href="{{ route('purchase.address.edit', $item) }}" class="purchase__group-link">
                            変更する
                        </a>
                    </div>

                    <div class="purchase__group-items">
                        <p class="purchase__group-item">
                            <span class="purchase__postal-mark">〒</span>{{ $shipping['postal_code'] }}
                        </p>

                        <p class="purchase__group-item">
                            {{ $shipping['address'] }}
                            @if(!empty($shipping['building_name']))
                                {{ $shipping['building_name'] }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="purchase__right">
                <table class="purchase__table">
                    <tr class="purchase__table-row">
                        <th class="purchase__table-head">商品代金</th>
                        <td class="purchase__table-data">
                            <span class="purchase__price-yen">¥</span>{{ number_format($item->price) }}
                        </td>
                    </tr>

                    <tr class="purchase__table-row">
                        <th class="purchase__table-head">支払い方法</th>
                        <td class="purchase__table-data" id="paymentMethodText">
                            {{ $paymentMethodLabel }}
                        </td>
                    </tr>
                </table>

                @if ($errors->has('purchase'))
                    <ul class="purchase__errors">
                        @foreach ($errors->get('purchase') as $error)
                            <li class="purchase__error">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="purchase__action">
                    <button type="submit" class="purchase__button">
                        購入する
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script src="{{ asset('js/purchase.js') }}"></script>

@endsection
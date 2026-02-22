@extends('layouts.app')

@section('head-title', '住所の変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/address.css') }}">
@endsection

@section('content')
    <div class="address-content">
        <div class="address-inner">
            <h1 class="address-title">住所の変更</h1>

            <form method="POST" action="{{ route('purchase.address.update', $item) }}" class="address-form">
                @csrf

                {{-- 郵便番号 --}}
                <div class="address-form__group">
                    <label class="address-form__label">郵便番号</label>
                    <input class="address-form__input u-input {{ $errors->has('shipping_postal_code') ? 'is-error' : '' }}" type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}">
                    @if ($errors->has('shipping_postal_code'))
                        <ul class="address-form__errors">
                            @foreach ($errors->get('shipping_postal_code') as $error)
                                <li class="address-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- 住所 --}}
                <div class="address-form__group">
                    <label class="address-form__label">住所</label>
                    <input class="address-form__input u-input {{ $errors->has('shipping_address') ? 'is-error' : '' }}" type="text" name="shipping_address" value="{{ old('shipping_address') }}">
                    @if ($errors->has('shipping_address'))
                        <ul class="address-form__errors">
                            @foreach ($errors->get('shipping_address') as $error)
                                <li class="address-form__error-list">
                                    {{$error}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- 建物名 --}}
                <div class="address-form__group">
                    <label class="address-form__label">建物名</label>
                    <input class="address-form__input" type="text" name="shipping_building_name" value="{{ old('shipping_building_name') }}">
                </div>

                <div class="address-form__actions">
                    <button class="address-form__submit" type="submit">登録する</button>
                </div>

            </form>
        </div>
    </div>
@endsection
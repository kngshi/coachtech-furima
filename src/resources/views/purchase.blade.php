@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection


@section('link')
<div class="flex">
    <div class="flex-content">
    <img src="img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a class="header-link" href="{{ route('logout') }}">ログアウト</a>
        <a class="header-link" href="{{ route('mypage') }}">マイページ</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @else
    <div class="flex-link">
        <a class="header-link" href="{{ route('login') }}" >ログイン</a>
        <a class="header-link" href="{{ route('register') }}">会員登録</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @endif
</div>
@endsection

@section('content')
<div class="grid__parent">
    <div class="grid__child__1">
        <div class="item-information__group">
            <div class="item-img">
            <img src="{{ $item->img_url }}" alt="商品画像" class="img-box">
            </div>
            <div class="item-information">
                <div class="item__name">{{ $item->name }}</div>
                <div class="item__price">¥{{ number_format($item->price) }}</div>
            </div>
        </div>
        <div class="purchase__group">
            <div class="payment-method">支払い方法</div>
            <a class="payment-method__link" href="">変更する</a>
        </div>
        <div class="purchase__group">
            <div class="shipping-address">配送先</div>
            <a class="shipping-address__link" href="{{ route('edit.address', ['item' => $item->id]) }}">変更する</a>
        </div>
    </div>
    <div class="grid__child__2">
        <div class="item-group">
            <table class="item-table">
                <tr class="item-table__row1">
                    <th class="item-table__header1">商品代金</th>
                    <td class="item-table__price">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="item-table__row2">
                    <th class="item-table__header">支払い金額</th>
                    <td class="item-table__payment">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="item-table__row3">
                    <th class="item-table__header">支払い方法</th>
                    <td class="item-table__payment-method">コンビニ払い</td>
                </tr>
            </table>
        </div>

        <form action="{{ route('purchase.item', ['item' => $item->id]) }}" method="POST">
        @csrf
        <button type="submit" class="purchase__button">購入する</button>
        </form>
    </div>
</div>
@endsection
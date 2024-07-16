@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
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
        <img src="{{ $item->img_url }}" alt="商品画像" class="img-box">
    </div>
    <div class="grid__child__2">
        <h1 class="item__name">{{ $item->name }}</h1>
        <div class="item__price">価格: {{ $item->price }}円</div>
        <div class="favicon-group">
            <div class="favicon-group__star">
                <i class="fa-regular fa-star fa-2xl"></i>
                <p class="">3</p>
            </div>
            <div class="favicon-group__comment">
                <i class="fa-regular fa-comment fa-2xl"></i>
                <p class="">14</p>
            </div>
        </div>
        <button class="purchase__button">購入する</button>

        <div class="item-group">
            <div class="item-group__label">商品説明</div>
            <div class="description__content">{{ $item->description }}</div>
        </div>
        <div class="item-group">
            <div class="item-group__label">商品の情報</div>
            <table class="item-table">
                <tr class="item-table__row">
                    <th class="item-table__header">カテゴリー</th>
                    <td class="item-table__category">表示</td>
                </tr>
                <tr class="item-table__row">
                    <th class="item-table__header">商品の状態</th>
                    <td class="item-table__condition">{{ $item->condition->condition }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

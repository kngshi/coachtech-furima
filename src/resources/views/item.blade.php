@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection


@section('link')
<div class="header-flex">
    <div class="flex-content">
        <a href="/">
            <img src="/img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
        </a>
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a href="{{ route('logout') }}" class="header-link"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">ログアウト
        </a>
        <form id="logout-form" class="header-link" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
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
@if (session('create'))
    <div class="flash-message__create">{{ session('create') }}</div>
@endif
@if (session('delete'))
    <div class="flash-message__delete">{{ session('delete') }}</div>
@endif
@if (session('fail'))
    <div class="flash-message__fail">{{ session('fail') }}</div>
@endif
<div class="grid-container">
    <div class="grid-left">
        <img src="{{ $item->img_url }}" alt="商品画像" class="img-box">
    </div>
    <div class="grid-right">
        <h1 class="item__name">{{ $item->name }}</h1>
        <div class="item__price">¥{{ number_format($item->price) }}</div>
        <div class="favicon-group">
            <div class="favicon-group__star">
            @auth
                @if (Auth::user()->likes->contains('item_id', $item->id))
                    <form action="{{ route('item.unlike', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="favicon-button">
                            <i class="fa-solid fa-star fa-2xl" style="color: yellow;" ></i>
                        </button>
                    </form>
                    <p class="favicon-count">{{ $item->likes->count() }}</p>
                @else
                    <form action="{{ route('item.like', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="favicon-button">
                            <i class="fa-regular fa-star fa-2xl" ></i>
                        </button>
                    </form>
                    <p class="favicon-count">{{ $item->likes->count() }}</p>
                @endif
            @else
                <a href="{{ route('login') }}">
                    <i class="fa-regular fa-star fa-2xl"></i>
                </a>
                <p class="favicon-count">{{ $item->likes->count() }}</p>
            @endauth
            </div>
            @auth
            <div class="favicon-group__comment">
                <a href="{{ route('create.comment', $item->id) }}">
                    <i class="fa-regular fa-comment fa-2xl" style="color: black;"></i>
                </a>
                <p class="favicon-count">{{ $item->comments ? $item->comments->count() : 0 }}</p>
            </div>
            @endauth
        </div>
        <form action="{{ route('post.detail') }}" method="POST">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <button type="submit" class="purchase__button">購入する</button>
        </form>
        <div class="comment-alternative">
            <div class="item-group">
                <div class="item-group__label">商品説明</div>
                <div class="description__content">{!! nl2br(e($item->description)) !!}</div>
            </div>
            <div class="item-group">
                <div class="item-group__label">商品の情報</div>
                <table class="item-table">
                    <tr class="item-table__row">
                        <th class="item-table__header">カテゴリー</th>
                        <td class="item-table__category">
                        @foreach($item->categories as $category)
                            {{ $category->name }}@if(!$loop->last), @endif
                        @endforeach
                        </td>
                    </tr>
                    <tr class="item-table__row">
                        <th class="item-table__header">商品の状態</th>
                        <td class="item-table__condition">{{ $item->condition->condition }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

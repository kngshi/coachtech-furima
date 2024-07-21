@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
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
@if (session('success'))
    <div class="flash-message__success">
        {{ session('success') }}
    </div>
@endif
<div class="mypage__heading">
    <div class="mypage__img">
        <img src="{{ $profile->img_url }}" alt="プロフィール画像" class="profile-img">
    </div>
    @auth
    <div class="mypage__user">{{Auth::user()->name}}</div>
    @endauth
    <a class="profile-link" href="{{ route('edit.profile') }}">プロフィールを編集</a>
</div>
<div class="tab">
    <ul class="tab-menu">
        <li class="tab-menu__item active">出品した商品</li>
        <li class="tab-menu__item">購入した商品</li>
    </ul>
    <div class="tab-content">
        <div class="tab-content__item show">
            <div class="items-index">
                @foreach($items as $item)
                <a href="{{ route('item.detail', $item->id) }}">
                    <img src="{{ $item->img_url }}" class="img-box" alt="{{ $item->name }}">
                </a>
                @endforeach
            </div>
        </div>
        <div class="tab-content__item">
            <div class="items-index">
                @foreach($soldItems as $soldItem)
                <a href="{{ route('item.detail', $item->id) }}">
                    <img src="{{ $soldItem->item->img_url }}" class="img-box" alt="{{ $soldItem->item->name }}" >
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    const tabs = document.getElementsByClassName('tab-menu__item');
    for (let i = 0; i < tabs.length; i++) {
      tabs[i].addEventListener('click', tabSwitch);
    }
    function tabSwitch() {
      document.getElementsByClassName('active')[0].classList.remove('active');
      this.classList.add('active');
      document.getElementsByClassName('show')[0].classList.remove('show');
      const arrayTabs = Array.prototype.slice.call(tabs);
      const index = arrayTabs.indexOf(this);
      document.getElementsByClassName('tab-content__item')[index].classList.add('show');
    };
</script>
@endsection
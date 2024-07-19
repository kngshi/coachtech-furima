@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
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
<div class="mypage__heading">
    <div class="mypage__img">
        <img src="{{ $profile->img_url }}" alt="プロフィール画像" class="profile-image">
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
        <div class="tab-content__item show">出品した商品の表示
            <div class="flex-items">
                <div class="img-box"></div>
                <div class="img-box"></div>
                <div class="img-box"></div>
                <div class="img-box"></div>
                <div class="img-box"></div>
            </div>
        </div>
        <div class="tab-content__item">購入した商品の表示
            <div class="flex-items">
                <div class="img-box"></div>
                <div class="img-box"></div>
                <div class="img-box"></div>
                <div class="img-box"></div>
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
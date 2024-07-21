@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection


@section('link')
<div class="flex">
    <div class="flex-content">
    <img src="img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a href="{{ route('logout') }}" class="header-link"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">ログアウト
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
<div class="tab">
    <ul class="tab-menu">
        <li class="tab-menu__item active">おすすめ</li>
        <li class="tab-menu__item">マイリスト</li>
    </ul>
    <div class="tab-content">
        <div class="tab-content__item show">おすすめ商品の表示
            <div class="flex-items">
                @foreach($items as $item)
                <a href="{{ route('item.detail', $item->id) }}">
                    <img src="{{ $item->img_url }}" class="img-box" alt="店舗画像">
                </a>
                @endforeach
            </div>
        </div>
        <div class="tab-content__item"></div>
        <div class="flex-items">
            @foreach($likedItems as $likedItem)
            <a href="{{ route('item.detail', $likedItem->id) }}">
                <img src="{{ $likedItem->img_url }}" class="img-box" alt="商品画像">
            </a>
            @endforeach
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

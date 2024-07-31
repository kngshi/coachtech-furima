@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="tab">
    <ul class="tab-menu">
        <li class="tab-menu__item active">おすすめ</li>
        @if(Auth::check())
        <li class="tab-menu__item">マイリスト</li>
        @else
        <a href="{{ route('login') }}" class="tab-menu__item">マイリスト</a>
        @endif
    </ul>
    <div class="tab-content">
        <div class="tab-content__item show">
            <div class="items-index">
                @foreach($items as $item)
                <a href="{{ route('item.detail', $item->id) }}">
                    <img src="{{ $item->img_url }}" class="img-box" alt="店舗画像">
                </a>
                @endforeach
            </div>
        </div>
        <div class="tab-content__item"></div>
        <div class="items-index">
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

@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search-results.css') }}" />
@endsection

@section('content')
@if($items->isNotEmpty())
    <div class="search-results">
        <h2 class="search-result__ttl">検索結果</h2>
        <div class="tab-content__item show">
            <div class="items-index">
                @foreach($items as $item)
                <div class="item-box">
                    <a href="{{ route('item.detail', $item->id) }}">
                        <img src="{{ $item->img_url }}" class="img-box" alt="店舗画像">
                    </a>
                    <div class="item-name">{{ $item->name }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <p>該当する商品が見つかりませんでした。</p>
@endif
@endsection
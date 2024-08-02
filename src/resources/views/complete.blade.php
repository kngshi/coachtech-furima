@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}" />
@endsection

@section('content')
<div class="container">
    <h2 class="complete-message">購入が完了しました。</h2>
    <p class="item-name">商品名: {{ $item->name }}</p>
    <p class="item-price">価格: {{ number_format($item->price) }}円</p>
    <a class="link" href="{{ route('index') }}">ホームに戻る</a>
</div>
@endsection


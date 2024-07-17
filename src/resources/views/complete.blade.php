@extends('layouts.common')

@section('content')
    <h1>購入完了</h1>
    <p>商品名: {{ $item->name }}</p>
    <p>価格: {{ $item->price }}円</p>
    <a href="{{ route('index') }}">ホームに戻る</a>
@endsection


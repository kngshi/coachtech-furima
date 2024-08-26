@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
@if (session('success'))
    <div class="flash-message__success">
        {{ session('success') }}
    </div>
@endif
@if (session('message'))
    <div class="flash-message__success">
        {{ session('message') }}
    </div>
@endif
@if (session('error'))
    <div class="flash-message__error">
        {{ session('error') }}
    </div>
@endif
<div class="grid-container">
    <div class="grid-left">
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
            <a class="payment-method__link" href="{{ route('payment.method.edit', ['item' => $item->id]) }}">変更する</a>
        </div>
        <div class="purchase__group">
            <div class="shipping-address">配送先</div>
            <a class="shipping-address__link" href="{{ route('edit.address', ['item' => $item->id]) }}">変更する</a>
        </div>
    </div>
    <div class="grid-right">
        <div class="item-group">
            <table class="item-table">
                <tr class="item-table__row--price">
                    <th class="item-table__header--price">商品代金</th>
                    <td class="item-table__price">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="item-table__row--payment">
                    <th class="item-table__header">支払い金額</th>
                    <td class="item-table__payment">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="item-table__row--payment">
                    <th class="item-table__header">支払い方法</th>
                    <td class="item-table__payment-method">
                    @if ($paymentMethod->id == 1)
                        クレジットカード
                    @elseif ($paymentMethod->id == 2)
                        コンビニ払い
                    @elseif ($paymentMethod->id == 3)
                        銀行振込
                    @endif
                </td>
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
@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment-method.css') }}" />
@endsection

@section('content')
<div class="container">
    <h1 class="payment-method__ttl">支払い方法の変更</h1>

    <form action="{{ route('payment.method.update', ['item' => $item->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="item_id" value="{{ request('item') }}">
        <div class="form-group">
        <div class="payment-method__message">支払い方法を選択してください</div>
        <div class="payment-method__label">
            <label>
                <input type="radio" name="payment_method_id" value="1" {{ $paymentMethod == 1 ? 'checked' : '' }}>
                クレジットカード
            </label>
        </div>
        <div class="payment-method__label">
            <label>
                <input type="radio" name="payment_method_id" value="2" {{ $paymentMethod == 2 ? 'checked' : '' }}>
                コンビニ払い
            </label>
        </div>
        <div class="payment-method__label">
            <label>
                <input type="radio" name="payment_method_id" value="3" {{ $paymentMethod == 3 ? 'checked' : '' }}>
                銀行振込
            </label>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">変更を保存</button>
    </form>
</div>
@endsection
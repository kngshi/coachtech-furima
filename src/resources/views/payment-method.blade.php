@extends('layouts.common')

@section('content')
<div class="container">
    <h1>支払い方法の変更</h1>

    <form action="{{ route('payment.method.update') }}" method="POST">
        @csrf
        <input type="hidden" name="item_id" value="{{ request('item') }}">
        <div class="form-group">
        <label>支払い方法を選択してください</label>
        <div>
            <label>
                <input type="radio" name="payment_method" value="0" {{ $payment_method == 0 ? 'checked' : '' }}>
                クレジットカード
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="payment_method" value="1" {{ $payment_method == 1 ? 'checked' : '' }}>
                コンビニ払い
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="payment_method" value="2" {{ $payment_method == 2 ? 'checked' : '' }}>
                銀行振込
            </label>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">変更を保存</button>
    </form>
</div>
@endsection
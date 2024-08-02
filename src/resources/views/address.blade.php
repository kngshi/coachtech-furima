@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('content')
@if (session('success'))
    <div class="flash-message__success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <div class="container__inner">
        <h2 class="address-form__heading">住所の変更</h2>
        <form action="{{ route('update.address', ['item' => $item->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="address-form__group">
                <div class="group">
                    <div class="address-form__postcode">
                        <label class="address-form__label">郵便番号</label>
                    </div>
                    <div class="address-form__inputs">
                        <input type="text" name="postcode" id="postcode" class="form-input" autocomplete="off" value="{{ old('postcode') }}" required>
                    </div>
                </div>
                <div class="group">
                    <div class="address-form__address">
                        <label class="address-form__label">住所</label>
                    </div>
                    <div class="address-form__inputs">
                        <input type="text" name="address" id="address" class="form-input" autocomplete="off" value="{{ old('address') }}" required>
                    </div>
                </div>
                <div class="group">
                    <div class="address-form__building">
                        <label class="address-form__label">建物名</label>
                    </div>
                    <div class="address-form__inputs">
                        <input type="text" name="building" id="building" class="form-input" autocomplete="off" value="{{ old('building') }}">
                    </div>
                </div>
            </div>
            <div class="address-form__group">
                <button type="submit" class="address-button">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
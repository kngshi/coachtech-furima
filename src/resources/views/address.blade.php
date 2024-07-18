@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('content')
 <div class="sell-form">
  <div class="sell-form__inner">
    <h2 class="sell-form__heading">住所の変更</h2>
    <form action="sell" method="post">
      @csrf
    <div class="sell-form__group">
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">郵便番号</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="postcode" id="postcode" class="form-input" autocomplete="off" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">住所</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="address" id="address" class="form-input" autocomplete="off" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__condition">
            <label class="sell-form__label">建物名</label>
        </div>
        <div class="sell-form__inputs">
            <input type="textarea" name="description" id="description" class="form-input" autocomplete="off" required>
        </div>
        </div>
    </div>
    <div class="sell-form__group">
        <button type="submit" class="sell-button">更新する</button>
    </div>
    </form>
  </div>
 </div>
@endsection
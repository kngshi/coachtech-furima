@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')
 <div class="sell-form">
  <div class="sell-form__inner">
    <h2 class="sell-form__heading">商品の出品</h2>
    <form action="sell" method="post">
      @csrf
      <div class="sell-form__group">
        <div class="sell-form__img">
            <div class="sell-form__img">
            <label class="sell-form__label" for="image">商品画像</label>
            </div>
            <div class="sell-form__img">
                <input type="file" name="img_url" id="img_url" class="img-select"required>
            </div>
        </div>
      </div>

    <div class="sell-form__group">
        <h3 class="sell-form__ttl">商品の詳細</h3>
        <div class="sell-form__img">
            <label class="sell-form__label">カテゴリー</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="category_id" id="category_id" class="form-input" autocomplete="off" required>
        </div>
        <div class="sell-form__img">
            <label class="sell-form__label">商品の状態</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="condition_id" id="condition_id" class="form-input" autocomplete="off" required>
        </div>
    </div>

    <div class="sell-form__group">
        <h3 class="sell-form__ttl">商品名と説明</h3>
        <div class="sell-form__img">
            <label class="sell-form__label">商品名</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="name" id="name" class="form-input" autocomplete="off" required>
        </div>
        <div class="sell-form__condition">
            <label class="sell-form__label">商品の説明</label>
        </div>
        <div class="sell-form__inputs">
            <input type="textarea" name="description" id="description" class="form-input" autocomplete="off" required>
        </div>
    </div>

    <div class="sell-form__group">
        <h3 class="sell-form__ttl">販売価格</h3>
        <div class="sell-form__img">
            <label class="sell-form__label">販売価格</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="price" id="price" class="form-input" autocomplete="off" required>
        </div>
    </div>
    <div class="sell-form__group">
        <button type="submit" class="sell-button">出品する</button>
    </div>
    </form>
  </div>
</div>
@endsection

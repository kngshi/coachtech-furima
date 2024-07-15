@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection


@section('link')
<div class="flex">
    <div class="flex-content">
        <img src="img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a class="header-link" href="{{ route('logout') }}">ログアウト</a>
        <a class="header-link" href="{{ route('mypage') }}">マイページ</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @else
    <div class="flex-link">
        <a class="header-link" href="{{ route('login') }}" >ログイン</a>
        <a class="header-link" href="{{ route('register') }}">会員登録</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @endif
</div>
@endsection

@section('content')
 <div class="sell-form">
  <div class="sell-form__inner">
    <h2 class="sell-form__heading">プロフィール設定</h2>
    <form action="sell" method="post">
      @csrf
      <div class="sell-form__group">
        <div class="group__img">
            <label class="label__image" for="image">商品画像</label>
            <input type="file" name="image" id="image" class="img-select"required>
            <button type="button" class="custom-file-button">画像を選択する</button>
            <span id="file-name"></span>
        </div>
      </div>

    <div class="sell-form__group">
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">ユーザー名</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="category" id="category" class="form-input" autocomplete="off" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">郵便番号</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="condition" id="condition" class="form-input" autocomplete="off" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">住所</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="name" id="name" class="form-input" autocomplete="off" required>
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
<script>
        document.querySelector('.custom-file-button').addEventListener('click', function() {
          document.getElementById('image').click();
        });

        document.getElementById('image').addEventListener('change', function() {
          const fileName = this.files[0] ? this.files[0].name : 'ファイルが選択されていません';
          document.getElementById('file-name').textContent = fileName;
        });
</script>
@endsection

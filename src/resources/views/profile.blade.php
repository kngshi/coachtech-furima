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
@if (session('success'))
    <div class="flash-message__success">
        {{ session('success') }}
    </div>
@endif
 <div class="sell-form">
  <div class="sell-form__inner">
    <h2 class="sell-form__heading">プロフィール設定</h2>
    <form action="{{ route('store.profile') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="sell-form__group">
        <div class="group__img">
            <img src="{{ $profile->img_url }}" alt="プロフィール画像" class="profile-image">
            <input type="file" name="img_url" id="img_url" class="img-select"required>
            <button type="button" class="custom-file-button">画像を選択する</button>
            <span id="file-name"></span>
        </div>
      </div>

    <div class="sell-form__group">
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">郵便番号</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="postcode" id="postcode" class="form-input" autocomplete="off" value="{{ old('postcode', $profile->postcode) }}" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__img">
            <label class="sell-form__label">住所</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="address" id="address" class="form-input" autocomplete="off" value="{{ old('address', $profile->address) }}" required>
        </div>
        </div>
        <div class="group">
        <div class="sell-form__condition">
            <label class="sell-form__label">建物名</label>
        </div>
        <div class="sell-form__inputs">
            <input type="text" name="building" id="building" class="form-input" autocomplete="off" value="{{ old('building', $profile->building) }}">
        </div>
        </div>
    </div>
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <div class="sell-form__group">
        <form action="{{ route('store.profile') }}" method="POST">
        @csrf
        <button type="submit" class="sell-button">更新する</button>
        </form>
    </div>
    </form>
</div>
</div>
<script>
        document.querySelector('.custom-file-button').addEventListener('click', function() {
          document.getElementById('img_url').click();
        });

        document.getElementById('img_url').addEventListener('change', function() {
          const fileName = this.files[0] ? this.files[0].name : 'ファイルが選択されていません';
          document.getElementById('file-name').textContent = fileName;
        });
</script>
@endsection
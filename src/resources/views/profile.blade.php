@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('link')
<div class="header-flex">
    <div class="flex-content">
        <img src="/img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a href="{{ route('logout') }}" class="header-link"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">ログアウト
        </a>
        <form id="logout-form" class="header-link" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
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
<div class="container">
    <div class="container__inner">
        <h2 class="container__heading">プロフィール設定</h2>
        <form action="{{ route('store.profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="profile-form__group">
                <div class="group-img">
                    @if ($profile)
                    <div class="img-item">
                        <img src="{{ $profile->img_url }}" alt="プロフィール画像" class="profile-img">
                    </div>
                    @else
                    <div class="profile-img__default"></div>
                    @endif
                    <div class="img-item">
                        <input type="file" name="img_url" id="img_url" class="img-select"required>
                        <button type="button" class="custom-file-button">画像を選択する</button>
                        <span id="file-name"></span>
                    </div>
                </div>
            </div>
            <div class="profile-form__group">
                <div class="profile-form__group">
                    <div class="profile-form__postcode">
                        <label class="profile-form__label">郵便番号</label>
                    </div>
                    <div class="profile-form__inputs">
                        @if ($profile)
                        <input type="text" name="postcode" id="postcode" class="form-input" autocomplete="off" value="{{ old('postcode', $profile->postcode) }}" required>
                        @else
                        <input type="text" name="postcode" id="postcode" class="form-input" autocomplete="off" value="{{ old('postcode') }}" required>
                        @endif
                    </div>
                </div>
                <div class="profile-form__group">
                    <div class="profile-form__address">
                        <label class="profile-form__label">住所</label>
                    </div>
                    <div class="profile-form__inputs">
                        @if ($profile)
                        <input type="text" name="address" id="address" class="form-input" autocomplete="off" value="{{ old('address', $profile->address) }}" required>
                        @else
                        <input type="text" name="address" id="address" class="form-input" autocomplete="off" value="{{ old('address') }}" required>
                        @endif
                    </div>
                </div>
                <div class="profile-form__group">
                    <div class="profile-form__building">
                        <label class="profile-form__label">建物名</label>
                    </div>
                    <div class="profile-form__inputs">
                        @if ($profile)
                        <input type="text" name="building" id="building" class="form-input" autocomplete="off" value="{{ old('building', $profile->building) }}">
                        @else
                        <input type="text" name="building" id="building" class="form-input" autocomplete="off" value="{{ old('building') }}">
                        @endif
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div class="profile-form__group">
                <form action="{{ route('store.profile') }}" method="POST">
                @csrf
                <button type="submit" class="profile-update__button">更新する</button>
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

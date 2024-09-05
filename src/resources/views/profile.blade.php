@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
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
                        <input type="file" name="img_url" id="img_url" class="img-select">
                        <button type="button" class="custom-file-button">画像を選択する</button>
                        <span id="file-name"></span>
                        @error('img_url')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="profile-form__group">
                <div class="profile-form__name">
                    <label class="profile-form__label">ユーザー名</label>
                </div>
                <div class="profile-form__inputs">
                    <input type="text" name="name" id="name" class="form-input" autocomplete="off" value="{{ old('name', Auth::user()->name) }}">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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
                    @error('postcode')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
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
                    @error('address')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
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
                    @error('building')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
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

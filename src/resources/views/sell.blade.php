@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')
@if (session('success'))
    <div class="flash-message__success">
        {{ session('success') }}
    </div>
@endif
<div class="sell-form">
    <div class="sell-form__inner">
        <h2 class="sell-form__heading">商品の出品</h2>
        <form action="sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell-form__group">
            <div class="sell-form__group--item">
                <div class="sell-form__img">
                <label class="sell-form__label" for="image">商品画像</label>
                </div>
                <div class="sell-form__select">
                    <input type="file" name="img_url" id="img_url" class="img-select"required>
                    <button type="button" class="custom-file-button">画像を選択する</button>
                    <span id="file-name"></span>
                </div>
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">商品の詳細</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">カテゴリー</label>
            </div>
            <div class="sell-form__inputs">
               <select name="category_id" id="category_id" class="form-input__category" multiple>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
                </select>
            </div>
            <div id="selected-categories" class="selected-categories">
                <div class="sell-form__group--item">
                    <label class="sell-form__label">選択されたカテゴリ</label>
                </div>
                <ul id="selected-categories-list"></ul>
            </div>
            <div class="sell-form__group--item">
                <label class="sell-form__label">商品の状態</label>
            </div>
            <div class="sell-form__inputs">
                <select name="condition_id" id="condition_id" class="form-input">
                <option value="">選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">商品名と説明</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">商品名</label>
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="name" id="name" class="form-input" autocomplete="off" required>
            </div>
            <div class="sell-form__condition">
                <label class="sell-form__label">商品の説明</label>
            </div>
            <div class="sell-form__inputs">
                <input type="textarea" name="description" id="description" class="form-input__textarea" autocomplete="off" required>
            </div>
            <div class="sell-form__group--item">
                <label class="sell-form__label">ブランド名</label>
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="brand" id="brand" class="form-input" autocomplete="off" >
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">販売価格</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">販売価格</label>
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="price" id="price" class="form-input" autocomplete="off" placeholder="¥" required>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <div class="sell-form__group">
            <button type="submit" class="sell-button">出品する</button>
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

    //カテゴリの表示 
    document.addEventListener('DOMContentLoaded', function() {
    const categoriesSelect = document.getElementById('category_id');
    const selectedCategoriesList = document.getElementById('selected-categories-list');

    categoriesSelect.addEventListener('change', function() {
        // 選択されたオプションを取得
        const selectedOptions = Array.from(categoriesSelect.selectedOptions);

        // 既存のリストをクリア
        selectedCategoriesList.innerHTML = '';

        // 選択されたカテゴリをリストに追加
        selectedOptions.forEach(option => {
            const listItem = document.createElement('li');
            listItem.textContent = option.text;
            selectedCategoriesList.appendChild(listItem);
        });
    });
});
</script>
@endsection

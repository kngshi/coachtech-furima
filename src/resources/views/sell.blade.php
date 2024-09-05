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
                    <input type="file" name="img_url" id="img_url" class="img-select">
                    <button type="button" class="custom-file-button">画像を選択する</button>
                    <span id="file-name"></span>
                    @error('img_url')
                            <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">商品の詳細</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">カテゴリー</label>
                @error('parent_category')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <select name="parent_category" id="parent_category" class="form-input__category">
                    <option value="">親カテゴリを選択</option>
                    @foreach($categories->where('parent_id', null) as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="child-category-container" style="display:none;" class="sell-form__group--item">
                <label for="child_category"  class="sell-form__label">子カテゴリ</label>
                <select id="child_category" name="category[]" class="form-input__category">
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
                @error('condition_id')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <select name="condition_id" id="condition_id" class="form-input">
                <option value="">選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->condition }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">商品名と説明</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">商品名</label>
                @error('name')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="name" id="name" class="form-input" autocomplete="off" required value="{{ old('name') }}">
            </div>
            <div class="sell-form__condition">
                <label class="sell-form__label">商品の説明</label>
                @error('description')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <textarea name="description" id="description" class="form-input__textarea" autocomplete="off" required>{{ old('description') }}</textarea>
            </div>
            <div class="sell-form__group--item">
                <label class="sell-form__label">ブランド名</label>
                @error('brand')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="brand" id="brand" class="form-input" autocomplete="off" value="{{ old('brand') }}">
            </div>
        </div>
        <div class="sell-form__group">
            <h3 class="sell-form__ttl">販売価格</h3>
            <div class="sell-form__group--item">
                <label class="sell-form__label">販売価格</label>
                @error('price')
                        <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="sell-form__inputs">
                <input type="text" name="price" id="price" class="form-input" autocomplete="off" placeholder="¥" required value="{{ old('price') }}">
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

//カテゴリ表示部分
document.addEventListener('DOMContentLoaded', function() {
    const parentCategorySelect = document.getElementById('parent_category');
    const childCategoryContainer = document.getElementById('child-category-container');
    const childCategorySelect = document.getElementById('child_category');
    const selectedCategoriesList = document.getElementById('selected-categories-list');

    // 親カテゴリが変更されたとき
    parentCategorySelect.addEventListener('change', function() {
        const parentId = this.value;

        if (parentId) {
            fetch(`/get-child-categories/${parentId}`)
                .then(response => response.json())
                .then(data => {
                    childCategorySelect.innerHTML = '<option value="">子カテゴリを選択</option>';
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        childCategorySelect.appendChild(option);
                    });
                    childCategoryContainer.style.display = 'block';
                });
        } else {
            childCategorySelect.innerHTML = '';
            childCategoryContainer.style.display = 'none';
        }
    });

    // 子カテゴリが変更されたとき
    childCategorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        const categoryName = this.options[this.selectedIndex].text;

        if (categoryId) {
            const listItem = document.createElement('li');
            listItem.textContent = categoryName;
            selectedCategoriesList.appendChild(listItem);
        }
    });
});
</script>
@endsection

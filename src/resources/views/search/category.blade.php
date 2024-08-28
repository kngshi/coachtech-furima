@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search/category.css') }}" />
@endsection

@section('content')
<div class="container">
    <h2>カテゴリーから探す</h2>
    <ul class="category-list">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('show.categories', ['id' => $category->id]) }}">
                    <span class="category-name">{{ $category->name }}</span>
                    <span class="arrow">&gt;</span>
                </a>
            </li>
        @endforeach
    </ul>
    <a href="javascript:history.back()" class="back-link">戻る</a>
</div>
@endsection
@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search/category-show.css') }}" />
@endsection

@section('content')
<div class="container">
    <h2 class="category__ttl">{{ $category->name }} のサブカテゴリー</h2>
    @if($childCategories->isNotEmpty())
        <ul class="category-list">
            @foreach($childCategories as $child)
                <li>
                    <a href="{{ route('search', ['category_id' => $child->id]) }}">
                        <span class="category-name">{{ $child->name }}</span>
                        <span class="arrow">&gt;</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>該当するサブカテゴリがありません。</p>
    @endif
    <a href="javascript:history.back()" class="back-link">戻る</a>
</div>
@endsection
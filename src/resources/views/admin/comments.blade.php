@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/comments.css') }}" />
@endsection

@section('content')
<div class="container">
    <h1 class="comment__ttl">アイテムのコメント管理</h1>
    <table class="comment__table">
        <thead>
            <tr class="comment__row">
                <th class="comment__label">アイテム名</th>
                <th class="comment__label">出品者</th>
                <th class="comment__label">コメント数</th>
                <th class="comment__label"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td class="comment__data">{{ $item->name }}</td>
                <td class="comment__data">{{ $item->user->name }}</td>
                <td class="comment__data--count">{{ $item->comments->count() }}</td>
                <td class="comment__data">
                    <a href="{{ route('create.comment', ['item' => $item->id]) }}" class="comment__detail-btn">詳細</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="back-link-container">
        <a href="/admin" class="back-link">戻る</a>
    </div>
</div>
@endsection
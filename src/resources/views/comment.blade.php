@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}" />
@endsection

@section('content')
@if (session('create'))
    <div class="flash-message__create">{{ session('create') }}</div>
@endif
@if (session('delete'))
    <div class="flash-message__delete">{{ session('delete') }}</div>
@endif
@if (session('fail'))
    <div class="flash-message__fail">{{ session('fail') }}</div>
@endif
<div class="grid-container">
    <div class="grid-left">
        <img src="{{ $item->img_url }}" alt="商品画像" class="img-box">
    </div>
    <div class="grid-right">
        <div class="item__name">{{ $item->name }}</div>
        <div class="item__brand">ブランド名：{{ $item->brand }}</div>
        <div class="item__price">¥{{ number_format($item->price) }}</div>
        <div class="favicon-group">
            <div class="favicon-group__star">
            @auth
                @if (Auth::user()->likes->contains('item_id', $item->id))
                    <form action="{{ route('item.unlike', $item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="favicon-button">
                            <i class="fa-solid fa-star fa-2xl" style="color: yellow;" ></i>
                        </button>
                    </form>
                    <p class="favicon-count">{{ $item->likes->count() }}</p>
                @else
                    <form action="{{ route('item.like', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="favicon-button">
                            <i class="fa-regular fa-star fa-2xl" ></i>
                        </button>
                    </form>
                    <p class="favicon-count">{{ $item->likes->count() }}</p>
                @endif
            @else
                <a href="{{ route('login') }}">
                    <i class="fa-regular fa-star fa-2xl"></i>
                </a>
                <p class="favicon-count">{{ $item->likes->count() }}</p>
            @endauth
            </div>
            <div class="favicon-group__comment">
                <div class="favicon-comment">
                    <i class="fa-regular fa-comment fa-2xl"></i>
                </div>
                <p class="favicon-count__comment">{{ $item->comments ? $item->comments->count() : 0 }}</p>
            </div>
        </div>
        <div class="comment-section">
            <div class="comment-list" style="max-height: 300px; overflow-y: scroll;">
                @foreach($comments as $comment)
                    <div class="comment-item">
                        <div class="flex-item">
                            <div class="user-information">
                                <img src="https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg" alt="user_img" class="user-img">
                            </div>
                            <div class="user-name">{{ $comment->user->name }}</div>
                        </div>
                        <div class="comment-group">
                            <div class="comment-left">{{ $comment->comment }}</div>
                            <div class="comment-right">
                            @if($comment->user_id === Auth::id() || Auth::user()->role === 1)
                                <form action="{{ route('destroy.comment', ['item' => $item->id, 'comment' => $comment->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">削除</button>
                                </form>
                            @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="comment-form__group">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('store.comment', $item->id) }}" method="POST">
                    @csrf
                    <div class="comment-form">
                        <div class="comment-label">商品へのコメント</div>
                        <textarea name="comment" class="comment-textarea" required value="{{ old('comment') }}"></textarea>
                    </div>
                    <div class="comment-form">
                        <button type="submit" class="comment-button">コメントを送信する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


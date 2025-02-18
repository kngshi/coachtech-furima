@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/notify.css') }}" />
@endsection

@section('content')
@if (session('success'))
    <div class="flash-message__success">{{ session('success') }}</div>
@endif
<div class="container">
    <div class="notify-form-container">
        <h1>お知らせメールの送信</h1>
        <form action="{{ route('admin.notify.send') }}" method="POST">
            @csrf
            <label for="subject">タイトル:</label>
            <input type="text" id="subject" name="subject" placeholder="タイトルを入力して下さい。" required>
            <br>
            <label for="message">本文:</label>
            <textarea id="message" name="message" placeholder="本文を入力して下さい。" required></textarea>
            <br>
            <button type="submit">メール送信</button>
        </form>
        <a href="/admin" class="back-link" >戻る</a>
    </div>
</div>
@endsection
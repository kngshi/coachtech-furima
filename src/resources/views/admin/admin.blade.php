@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1 class="admin-ttl">管理者ダッシュボード</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="dashboard-sections">
            <div class="dashboard-section">
                <a href="/admin/user-index" class="admin-link">ユーザー管理</a>
            </div>
            <div class="dashboard-section">
                <a href="{{ route('admin.comments') }}" class="admin-link">コメント管理</a>
            </div>
        </div>
        <div class="dashboard-sections">
            <div class="notify-section">
                <a href="/admin/notify" class="notify-link">お知らせメールの送信</a>
            </div>
        </div>
    </div>
@endsection

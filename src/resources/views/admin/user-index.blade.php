@extends('layouts.common')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user-index.css') }}" />
@endsection

@section('content')
<div class="container">
    <h2 class="user-index__ttl">ユーザー管理</h2>
    <table class="admin__table">
        <thead>
            <tr class="admin__row">
                <th class="admin__label">名前</th>
                <th class="admin__label">メールアドレス</th>
                <th class="admin__label">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="admin__data">{{ $user->name }}</td>
                <td class="admin__data">{{ $user->email }}</td>
                <td class="admin__data">
                    <a class="admin__detail-btn" href="#{{$user->id}}">詳細</a>
                </td>
            </tr>
        <div class="modal" id="{{$user->id}}">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal__inner">
          <div class="modal__content">
            <form class="modal__detail-form" action="{{ route('admin.delete', $user->id) }}" method="post">
            @csrf
            @method('DELETE')
              <div class="modal-form__group">
                <label class="modal-form__label" for="">お名前</label>
                <p>{{$user->name}}</p>
              </div>
              <div class="modal-form__group">
                <label class="modal-form__label" for="">メールアドレス</label>
                <p>{{$user->email}}</p>
              </div>
              <div class="modal-form__group">
                <label class="modal-form__label" for="">郵便番号</label>
                @if($user->profile)
                <p>{{$user->profile->postcode}}</p>
                @else
                <p>未設定</p>
                @endif
              </div>
              <div class="modal-form__group">
                <label class="modal-form__label" for="">住所</label>
                @if($user->profile)
                <p>{{$user->profile->address}}</p>
                @else
                <p>未設定</p>
                @endif
              </div>
              <div class="modal-form__group">
                <label class="modal-form__label" for="">建物名</label>
                @if($user->profile)
                <p>{{$user->profile->building}}</p>
                @else
                <p></p>
                @endif
              </div>
              <input class="modal-form__delete-btn btn" type="submit" value="削除">
            </form>
          </div>
          <a href="#" class="modal__close-btn">×</a>
        </div>
      </div>
        @endforeach
        </tbody>
    </table>
    <div class="back-link-container">
        <a href="/admin" class="back-link">戻る</a>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-form__delete-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            if (confirm('本当に削除しますか？')) {
                button.closest('form').submit();
            }
        });
    });
});
</script>
@endsection
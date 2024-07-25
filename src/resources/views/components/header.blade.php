<div class="header-flex">
    <div class="flex-content">
        <a href="/">
            <img src="img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
        </a>
    </div>
    @if(Auth::check())
    <div class="flex-link">
        <a href="{{ route('logout') }}" class="header-link"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">ログアウト
        </a>
        <form id="logout-form" class="header-link" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a class="header-link" href="{{ route('mypage') }}">マイページ</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @else
    <div class="flex-link">
        <a class="header-link" href="{{ route('login') }}" >ログイン</a>
        <a class="header-link" href="{{ route('register') }}">会員登録</a>
        <a class="header-button" href="/sell">出品</a>
    </div>
    @endif
</div>
<div class="header-flex">
    <div class="flex-content">
        <div class="flex-content__item">
            <a href="/">
                <img src="/img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
            </a>
        </div>
        <div class="flex-content__item">
            <form action="{{ route('search') }}" method="GET"  class="search-form" id="accordion-button">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search-input">
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                </button>
            </form>
            <div class="accordion-content" id="accordion-content">
                <a href="{{ route('search.category') }}" class="dropdown-item">
                    <span class="dropdown-text">カテゴリーから探す</span>
                    <span class="dropdown-arrow">&gt;</span>
                </a>
            </div>
        </div>
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
<script>
document.getElementById('accordion-button').addEventListener('click', function(event) {
    // 検索ボタンがクリックされたかどうかを確認
    var isSearchButtonClicked = event.target.closest('button');

    // 検索ボタンがクリックされた場合、フォームを送信する
    if (isSearchButtonClicked) {
        return; // ここでreturnすることで、フォーム送信を許可
    }

    event.preventDefault(); // フォームが送信されるのを防ぐ
    var accordionContent = document.getElementById('accordion-content');
    
    if (accordionContent.style.display === 'block') {
        accordionContent.style.display = 'none';
    } else {
        accordionContent.style.display = 'block';
    }
});

// 他の場所をクリックしたときにアコーディオンを閉じる処理
document.addEventListener('click', function(event) {
    var isClickInside = document.getElementById('accordion-button').contains(event.target);

    if (!isClickInside) {
        document.getElementById('accordion-content').style.display = 'none';
    }
});
</script>
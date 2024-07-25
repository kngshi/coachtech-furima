<form action="{{ route('index') }}" method="GET" class="search-form">
    <input type="text" name="query" placeholder="なにをお探しですか？" class="search-input">
    <div class="dropdown">
        <button type="button" class="dropdown-toggle">カテゴリから探す</button>
        <div class="dropdown-menu">
            @foreach($categories as $category)
                <a href="{{ route('index', ['category' => $category->id]) }}" class="dropdown-item">{{ $category->name }}</a>
            @endforeach
        </div>
        <button type="submit" class="search-button">
            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        </button>
    </div>
    
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownInput = document.querySelector('.dropdown-input');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    dropdownInput.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });
    
    document.addEventListener('click', function(event) {
        if (!dropdownInput.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
</script>
<style>
.dropdown {
    position: relative;
    display: inline-block; /* 親要素の流れに従う */
    
}

.dropdown-input {
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    padding: 5px;
    cursor: pointer;
    width: 100%; /* 入力ボックスを親の幅に合わせる */
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: blue;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 1000;
    width: 100%; /* ドロップダウンメニューの幅を親に合わせる */
    top: 100%; /* 入力ボックスの下に表示する */

}
.dropdown-toggle {
    position: absolute;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 1000;
    width: 100%; /* ドロップダウンメニューの幅を親に合わせる */
    top: 200%; /* 入力ボックスの下に表示する */
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    padding: 10px;
    text-decoration: none;
    color: #007bff;
    display: block;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.search-form {
    padding-top: 15px;
}

.search-input {
    margin-left:15px;
    padding-left:20px;
    font-size: 16px;
    height:40px;
    width: 320px;
    border-radius:5px;
}

.search-button {
    position: relative;
    background: white;
    height: 32px;
    width: 32px;
    cursor: pointer;
    margin:0 -40px;
    border-radius:3px;
}

.search-button img {
    width: 16px;
    height: 16px;
}
</style>
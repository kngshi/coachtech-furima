document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const dropdownMenu = document.getElementById('dropdown-menu');

    searchInput.addEventListener('focus', function() {
        dropdownMenu.style.display = 'block';
    });

    searchInput.addEventListener('blur', function() {
        setTimeout(function() {
            dropdownMenu.style.display = 'none';
        }, 200);
    });

    dropdownMenu.addEventListener('mousedown', function(event) {
        event.preventDefault();
    });
});

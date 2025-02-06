const searchInput = document.getElementById('category-search');
const categorySelect = document.getElementById('categories');

searchInput.addEventListener('input', function () {
    const searchText = searchInput.value.toLowerCase();
    const options = categorySelect.querySelectorAll('option');

    options.forEach(option => {
        const categoryName = option.textContent.toLowerCase();
        if (categoryName.includes(searchText)) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
});

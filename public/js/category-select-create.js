document.getElementById('add-category-btn').addEventListener('click', function() {
    let selectedCategories = Array.from(document.getElementById('categories').selectedOptions);
    let selectedCategoriesContainer = document.getElementById('selected-categories');

    if (selectedCategoriesContainer.children.length >= 4) {
        alert("No puedes seleccionar más de 4 categorías.");
        return;
    }

    selectedCategories.forEach(option => {
        let categoryDiv = document.createElement('div');
        categoryDiv.classList.add('flex', 'items-center', 'justify-between', 'bg-gray-200', 'px-4', 'py-2', 'rounded-lg', 'space-x-4', 'border', 'border-gray-300');

        let categoryName = document.createElement('span');
        categoryName.textContent = option.text;
        categoryName.classList.add('text-gray-800', 'font-medium');

        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'categories[]';
        input.value = option.value;

        let removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.textContent = 'Eliminar';
        removeButton.classList.add('text-red-500', 'hover:text-red-700', 'focus:outline-none', 'focus:ring-2', 'focus:ring-red-500');

        removeButton.addEventListener('click', function() {
            selectedCategoriesContainer.removeChild(categoryDiv);
        });

        categoryDiv.appendChild(categoryName);
        categoryDiv.appendChild(removeButton);
        categoryDiv.appendChild(input);

        selectedCategoriesContainer.appendChild(categoryDiv);

        option.selected = false;
    });
});

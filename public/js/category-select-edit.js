document.addEventListener('DOMContentLoaded', function() {
    const selectedCategories = JSON.parse(document.getElementById('selected-categories').dataset.categories);
    const categoriesSelect = document.getElementById('categories');
    const selectedCategoriesContainer = document.getElementById('selected-categories');

    function addCategoryToSelected(option) {
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
            option.selected = false;
        });

        categoryDiv.appendChild(categoryName);
        categoryDiv.appendChild(removeButton);
        categoryDiv.appendChild(input);
        selectedCategoriesContainer.appendChild(categoryDiv);
    }

    selectedCategories.forEach(categoryId => {
        const option = categoriesSelect.querySelector(`option[value="${categoryId}"]`);
        if (option) {
            addCategoryToSelected(option);
            option.selected = false;
        }
    });

    document.getElementById('add-category-btn').addEventListener('click', function() {
        let selectedCategories = Array.from(categoriesSelect.selectedOptions);

        if (selectedCategoriesContainer.children.length >= 4) {
            alert("No puedes seleccionar más de 4 categorías.");
            return;
        }

        selectedCategories.forEach(option => {
            const alreadyAdded = Array.from(selectedCategoriesContainer.getElementsByTagName('input')).some(input => input.value === option.value);
            if (alreadyAdded) return;

            addCategoryToSelected(option);
            option.selected = false;
        });
    });
});

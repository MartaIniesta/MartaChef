document.getElementById('image').addEventListener('change', function(event) {
    console.log("Evento change detectado");

    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log("Imagen cargada:", e.target.result);

            let container = document.getElementById('imagePreview');
            container.innerHTML = '';

            let imgPreview = document.createElement('img');
            imgPreview.id = 'currentImage';
            imgPreview.src = e.target.result;
            imgPreview.classList.add('w-32', 'h-32', 'object-cover', 'rounded-md', 'border');

            container.appendChild(imgPreview);
        };
        reader.readAsDataURL(file);
    }
});

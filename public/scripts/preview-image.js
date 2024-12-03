function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}
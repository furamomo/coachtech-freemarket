document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('itemImageInput');
    const preview = document.getElementById('itemImagePreview');

    if (!input || !preview) return;

    const wrapper = preview.closest('.create__image');
    if (!wrapper) return;

    input.addEventListener('change', (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = () => {
            preview.src = reader.result;
            wrapper.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    });
});

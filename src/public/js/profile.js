document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('profileImageInput');
    const preview = document.getElementById('profilePreview');

    if (!input || !preview) return;

    input.addEventListener('change', (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = () => {
            preview.src = reader.result;
        };
        reader.readAsDataURL(file);
    });
});

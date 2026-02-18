document.addEventListener('DOMContentLoaded', () => {
    const link = document.querySelector('.purchase__group-link');
    const select = document.getElementById('payment_method');
    const text = document.getElementById('paymentMethodText');

    if (!select) return;

    const labelMap = {
        '1': 'コンビニ支払い',
        '2': 'カード支払い',
    };

    const updateText = () => {
        const value = select.value;
        if (!text) return;
        text.textContent = labelMap[value] ?? '未選択';
    };

    updateText();

    select.addEventListener('change', updateText);

    if (!link) return;

    link.addEventListener('click', () => {
        const value = select.value;
        if (!value) return;

        const url = new URL(link.href);
        url.searchParams.set('payment_method', value);
        link.href = url.toString();
    });
});

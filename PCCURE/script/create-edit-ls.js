const container = document.querySelector('.product-info'),
    actionBtn = document.querySelector('.product-info .right-side .action-btn'),
    overlay = document.querySelector('.product-info .overlay'),
    cancelBtn = document.querySelector('.product-info .modal button');

actionBtn.onclick = () => {
    container.classList.add('confirmation');
}

overlay.onclick = () => {
    container.classList.remove('confirmation');
}

cancelBtn.onclick = () => {
    container.classList.remove('confirmation');
}
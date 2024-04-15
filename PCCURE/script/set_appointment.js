// ---------- Modal ----------
const container = document.querySelector('.product-info'),
    noBtn = document.querySelector('.product-info .modal button'),
    setBtn = document.querySelector('.product-info .right-side button'),
    overlay = document.querySelector('.product-info .overlay');

setBtn.onclick = () => {
    container.classList.add('confirmation');
}

overlay.onclick = () => {
    container.classList.remove('confirmation');
}

noBtn.onclick = () => {
    container.classList.remove('confirmation');
}
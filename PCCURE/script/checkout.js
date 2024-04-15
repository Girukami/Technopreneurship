// ---------- Price Update ----------
const price = document.querySelector('.checkout .info #price'),
    quantity = document.querySelector('.checkout .info #quantity'),
    totalPrice = document.querySelector('.checkout .info #total-price'),
    grandTotal = document.querySelector('.checkout .payment #grand-total');

function updatePrice() {
    totalPrice.innerHTML = (price.innerHTML * quantity.value).toFixed(2);
    grandTotal.innerHTML = (price.innerHTML * quantity.value + 2).toFixed(2);

}

updatePrice();

quantity.addEventListener('input', updatePrice);


// ---------- Modal ----------
const cancelBtn = document.querySelector('.checkout .right-side .cancel-btn'),
    container = document.querySelector('.checkout'),
    noBtn = document.querySelector('.checkout .modal button'),
    overlay = document.querySelector('.checkout .overlay');

cancelBtn.onclick = () => {
    container.classList.add('confirmation');
}

overlay.onclick = () => {
    container.classList.remove('confirmation');
}

noBtn.onclick = () => {
    container.classList.remove('confirmation');
}
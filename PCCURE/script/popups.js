const popups = document.querySelector('.popups'),
    closeBtn = document.querySelector('.popups .close');

closeBtn.onclick = () => {
    popups.style.display = 'none';
}
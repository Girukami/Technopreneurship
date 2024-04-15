const navbar = document.querySelector('.header nav'),
    account = document.querySelector('.header nav .account'),
    navOverlay = document.querySelector('.header nav .nav-overlay');

account.onclick = () => {
    navbar.classList.add('active');
}

navOverlay.onclick = () => {
    navbar.classList.remove('active');
}
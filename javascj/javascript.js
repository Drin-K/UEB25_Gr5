const hamburger = document.querySelector('.senvichi');
const navMenu = document.querySelector('.navbar');


hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});
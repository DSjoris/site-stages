const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
    console.log("test")
    navLinks.classList.toggle('active');
});
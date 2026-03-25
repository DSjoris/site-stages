const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
    console.log("test")
    navLinks.classList.toggle('active');
});
function openModal() {
    document.getElementById('modalPostuler').classList.add('active');
}

function closeModal() {
    document.getElementById('modalPostuler').classList.remove('active');
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalPostuler');
    if (modal && e.target === modal) closeModal();
});
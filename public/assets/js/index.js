// navbar - burger menu
const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// postuler
const applyForm = document.getElementById('applyForm');
const cvs = document.getElementsByName('id_cv');
const inputCv = document.getElementById('input-cv');
const errorApplyField = document.getElementById('errorApply');

applyForm.addEventListener('submit', (e) => {
    let cv_checked = false;
    cvs.forEach(cv => {
        if (cv.checked && cv.value !== 'none') cv_checked = true;
    });

    if (!cv_checked && !inputCv.files.length) {
        e.preventDefault();
        errorApplyField.textContent = 'Veuillez sélectionner un CV pour postuler.';
    }
});

cvs.forEach(cv => {
    cv.addEventListener('change', () => {
        if (cv.checked && cv.value !== 'none') {
            inputCv.disabled = true;
            inputCv.value = '';
            errorApplyField.textContent = '';
        } else {
            inputCv.disabled = false;
        }
    });
});

inputCv.addEventListener('change', () => {
    if (inputCv.files.length) {
        errorApplyField.textContent = '';
    }
});
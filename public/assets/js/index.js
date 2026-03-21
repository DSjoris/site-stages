// postuler
const applyForm = document.getElementById('applyForm');
const cvs = document.getElementsByName('id_cv');
const inputCv = document.getElementById('input-cv');
const errorApplyField = document.getElementById('errorApply');

if (applyForm && inputCv && errorApplyField && cvs.length) {
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
}



document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    if (burger && navLinks) {
        burger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }

    const input = document.getElementById('address');
    const dropdown = document.getElementById('address-dropdown');

    if (!input || !dropdown) return;

    let debounceTimer = null;

    function hideDropdown() {
        dropdown.innerHTML = '';
        dropdown.classList.add('hidden');
    }

    function showDropdown(features) {
        dropdown.innerHTML = '';

        if (!features || features.length === 0) {
            hideDropdown();
            return;
        }

        features.forEach((feature) => {
            const option = document.createElement('div');
            option.className = 'address-option';
            option.textContent = feature.properties.label;

            option.addEventListener('click', function () {
                input.value = feature.properties.label;
                hideDropdown();
            });

            dropdown.appendChild(option);
        });

        dropdown.classList.remove('hidden');
    }

    input.addEventListener('input', function () {
        const query = input.value.trim();
        console.log("ça tape :", query);

        clearTimeout(debounceTimer);    

        if (query.length < 3) {
            console.log("trop court");
            hideDropdown();
            return;
        }

        debounceTimer = setTimeout(async function () {
            try {
                console.log("requête envoyée pour :", query);

                const response = await fetch(
                    `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=5`
                );

                console.log("status =", response.status);

                if (!response.ok) {
                    throw new Error('Réponse API invalide');
                }

                const data = await response.json();
                console.log("data API =", data);

                showDropdown(data.features || []);
            } catch (error) {
                console.error('Erreur autocomplete adresse :', error);
                hideDropdown();
            }
        }, 300);
    });

    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target) && e.target !== input) {
            hideDropdown();
        }
    });
});


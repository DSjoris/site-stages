<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
// navbar - burger menu
=======
>>>>>>> 91e6c56 (Ajout de la page des entreprises avec une recherche et une pagination)
=======
>>>>>>> 0beb2c7 (Je remet tout le projet)
const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
<<<<<<< HEAD
<<<<<<< HEAD
    navLinks.classList.toggle('active');
});

>>>>>>> 26ce283 (amélioration de la création d'entreprise et amélioration de la liste d'entreprises avec les adresses opérationnel)
=======
>>>>>>> 2488289 (fix: corrections après rebase)
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
<<<<<<< HEAD

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
=======

        if (!cv_checked && !inputCv.files.length) {
            e.preventDefault();
            errorApplyField.textContent = 'Veuillez sélectionner un CV pour postuler.';
>>>>>>> 2488289 (fix: corrections après rebase)
        }
    });

<<<<<<< HEAD

inputCv.addEventListener('change', () => {
    if (inputCv.files.length) {
        errorApplyField.textContent = '';
    }
    console.log("test")
    navLinks.classList.toggle('active');
<<<<<<< HEAD
});
=======
>>>>>>> 91e6c56 (Ajout de la page des entreprises avec une recherche et une pagination)
=======
    console.log("test")
    navLinks.classList.toggle('active');
>>>>>>> 0beb2c7 (Je remet tout le projet)
});
=======
console.log("JS OK");
=======
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


>>>>>>> 2488289 (fix: corrections après rebase)

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

<<<<<<< HEAD
>>>>>>> c9115d4 (amélioration de la création d'entreprise et amélioration de la liste d'entreprises avec les adresses opérationnel)
>>>>>>> 26ce283 (amélioration de la création d'entreprise et amélioration de la liste d'entreprises avec les adresses opérationnel)
=======
>>>>>>> 2488289 (fix: corrections après rebase)

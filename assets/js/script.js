document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("signup");
    const submitBtn = document.getElementById("submitBtn");

    submitBtn.addEventListener("click", function(event) {
        let valid = true;

        // Validazione del campo Nome
        const nameInput = document.getElementById("name");
        const nameError = document.getElementById("nameError");
        if (nameInput.value.trim() === "") {
            valid = false;
            nameError.textContent = "Il campo Name è obbligatorio.";
        } else {
            nameError.textContent = ""; // Pulisci il messaggio di errore se è valido
        }

        // Validazione del campo Surname
        const surnameInput = document.getElementById("surname");
        const surnameError = document.getElementById("surnameError");
        if (surnameInput.value.trim() === "") {
            valid = false;
            surnameError.textContent = "Il campo Surname è obbligatorio.";
        } else {
            surnameError.textContent = ""; // Pulisci il messaggio di errore se è valido
        }

        // Validazione del campo Email
        const emailInput = document.getElementById("email");
        const emailError = document.getElementById("emailError");
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailRegex.test(emailInput.value)) {
            valid = false;
            emailError.textContent = "Inserisci un indirizzo email valido.";
        } else {
            emailError.textContent = ""; // Pulisci il messaggio di errore se è valido
        }

        // Validazione del campo Password
        const passwordInput = document.getElementById("password");
        const passwordError = document.getElementById("passwordError");
        if (passwordInput.value.length < 8) {
            valid = false;
            passwordError.textContent = "La password deve contenere almeno 8 caratteri.";
        } else {
            passwordError.textContent = ""; // Pulisci il messaggio di errore se è valido
        }

        // Se la validazione fallisce, impedisci l'invio del modulo
        if (!valid) {
            event.preventDefault();
        }
    });
});

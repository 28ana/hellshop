function setError(element, errorSpan, message) {
    element.classList.add("error-border");
    errorSpan.textContent = message;
}

function clearError(element, errorSpan) {
    element.classList.remove("error-border");
    errorSpan.textContent = "";
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        let isValid=true;
        const name = document.getElementById("name");
        const nameValue = name.value.trim();
        const email = document.getElementById("email");
        const emailValue = email.value.trim();
        const subject = document.getElementById("subject");
        const subjectValue = subject.value.trim();
        const message = document.getElementById("message");
        const messageValue = message.value.trim();
        const nameError = document.getElementById("name-error");
        const emailError = document.getElementById("email-error");
        const subjectError = document.getElementById("subject-error");
        const messageError = document.getElementById("message-error");

        const nameReg = /^[A-ZĐŽĆČŠ][a-zđžćčš]+(\s[A-ZĐŽĆČŠ][a-zđžćčš]+)*$/;
        const emailReg = /^([a-z0-9._%+-]+)@([a-z0-9.-]+)\.([a-z]{2,})$/;
        
        if (!nameReg.test(nameValue)) {
            setError(name, nameError, "Ime nije u dobrom formatu.");
            isValid = false;
        }
        else {
        clearError(name, nameError);
        }

        if (!emailReg.test(emailValue)) {
            setError(email, emailError, "Unesite ispravnu email adresu (nedostaje @ ili domen).");
            isValid = false;
        }
        else {
        clearError(email, emailError);
        }
        
        if (subjectValue==="") {
            setError(subject, subjectError, "Tema ne moze biti prazna.");
            isValid = false;
        }
        else {
        clearError(subject, subjectError);
        }
        
        if (messageValue==="") {
            setError(message, messageError, "Poruka ne moze biti prazna.");
            isValid = false;
        }
        else {
        clearError(message, messageError);
        }
        
        if (!isValid) {
        e.preventDefault();
        }
    });


    const searchCity = document.getElementById('searchCity');
    const searchParking = document.getElementById('searchParking');
    const table = document.getElementById('table');

    // Funkcija koja radi samo filtriranje
    function filterTable() {
        const cityValue = searchCity.value.toLowerCase().trim();
        const parkingValue = searchParking.value.toLowerCase().trim();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            // Indeks 0 je 'Grad', indeks 4 je 'Parking'
            const cityText = row.cells[0].textContent.toLowerCase().trim();
            const parkingText = row.cells[4].textContent.toLowerCase().trim();

            // Provera grada: mora da počinje unetim tekstom
            const cityMatch = cityText.startsWith(cityValue);

            // Provera parkinga: "Sve" ili tačno podudaranje
            const parkingMatch = (parkingValue === "") || (parkingText === parkingValue);

            // Prikaži red samo ako oba uslova važe
            if (cityMatch && parkingMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Osluškujemo kucanje u polju za grad
    if (searchCity) {
        searchCity.addEventListener('input', filterTable);
    }

    // Osluškujemo promenu u dropdown listi
    if (searchParking) {
        searchParking.addEventListener('change', filterTable);
    }
});


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
        const phone = document.getElementById("phone");
        const phoneValue = phone.value.trim();
        const email = document.getElementById("email");
        const emailValue = email.value.trim();
        const password = document.getElementById("password");
        const passwordValue=password.value.trim();
        const cpassword = document.getElementById("cpassword");
        const cpasswordValue=cpassword.value.trim();
        const nameError = document.getElementById("name-error");
        const phoneError = document.getElementById("phone-error");
        const emailError = document.getElementById("email-error");
        const passwordError = document.getElementById("password-error");
        const cpasswordError = document.getElementById("cpassword-error");

        const nameReg = /^[A-ZĐŽĆČŠ][a-zđžćčš]+(\s[A-ZĐŽĆČŠ][a-zđžćčš]+)*$/;
        const phoneReg=/^(\+3816\d{7,8}|06\d{7,8})$/;
        const emailReg = /^([a-z0-9._%+-]+)@([a-z0-9.-]+)\.([a-z]{2,})$/;
        const passReg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        
        if (!nameReg.test(nameValue)) {
            setError(name, nameError, "Ime nije u dobrom formatu.");
            isValid = false;
        }
        else {
        clearError(name, nameError);
        }

        if (!phoneReg.test(phoneValue)) {
            setError(phone, phoneError, "Telefon nije u dobrom formatu.");
            isValid = false;
        }
        else {
        clearError(phone, phoneError);
        }

        if (!emailReg.test(emailValue)) {
            setError(email, emailError, "Unesite ispravnu email adresu (nedostaje @ ili domen).");
            isValid = false;
        }
        else {
        clearError(email, emailError);
        }

        if (!passReg.test(passwordValue)) {
            setError(password, passwordError, "Lozinka nije u dobrom formatu.");
            isValid = false;
        }
        else {
        clearError(password, passwordError);
        }

        if (passwordValue !== cpasswordValue) {
            setError(cpassword, cpasswordError, "Lozinke se ne podudaraju.");
            isValid = false;
        }
        else {
        clearError(cpassword, cpasswordError);
        }
        
        if (!isValid) {
        e.preventDefault();
        }
    });
});
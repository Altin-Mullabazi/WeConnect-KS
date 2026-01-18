const form = document.getElementById("loginForm");
const email = document.getElementById("email");
const password = document.getElementById("password");
const successMessage = document.getElementById("successMessage");

form.addEventListener("submit", function (e) {
    e.preventDefault();
    
    if (!email.value.trim()) {
        alert("Email eshte i detyrueshem");
        return;
    }
    
    if (email.value.indexOf('@') === -1) {
        alert("Email nuk eshte valid");
        return;
    }
    
    if (!password.value.trim()) {
        alert("Fjalekalimi eshte i detyrueshem");
        return;
    }
    
    successMessage.textContent = "Hyrja u realizua me sukses!";
    form.reset();
});

const form = document.getElementById('registerForm');
const successMessage = document.getElementById('successMessage');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    
    const nameEl = document.getElementById('fullName');
    const emailEl = document.getElementById('email');
    const passEl = document.getElementById('password');
    const confirmEl = document.getElementById('confirmPassword');
    const terms = document.getElementById('terms');
    
    let valid = true;
    
    if (!nameEl.value.trim()) {
        alert('Shkruaj emrin tuaj');
        valid = false;
    }
    
    if (valid && emailEl.value.indexOf('@') === -1) {
        alert('Shkruaj nje email te vlefshem');
        valid = false;
    }
    
    if (valid && passEl.value.length < 8) {
        alert('Fjalekalimi duhet te kete te pakten 8 karaktere');
        valid = false;
    }
    
    if (valid && passEl.value !== confirmEl.value) {
        alert('Fjalekalimet nuk perputhen');
        valid = false;
    }
    
    if (valid && !terms.checked) {
        alert('Duhet te pranoni termat');
        valid = false;
    }
    
    if (valid) {
        successMessage.textContent = 'Llogaria u krijua me sukses!';
        successMessage.style.display = 'block';
        form.reset();
        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000);
    }
});
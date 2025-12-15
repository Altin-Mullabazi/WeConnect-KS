document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    const successMessage = document.getElementById('successMessage');

    function setError(input, message) {
        const err = input.parentElement.querySelector('.error-message');
        if (err) err.textContent = message;
        input.classList.add('invalid');
    }

    function clearAll() {
        document.querySelectorAll('.error-message').forEach(e => e.textContent = '');
        document.querySelectorAll('input').forEach(i => i.classList.remove('invalid'));
        successMessage.style.display = 'none';
        successMessage.textContent = '';
    }

    function isSimpleEmail(email) {
        if (!email) return false;
        email = email.trim();
        const at = email.indexOf('@');
        if (at <= 0) return false; 
        const dot = email.indexOf('.', at + 2); 
        if (dot === -1) return false;
        if (dot === email.length - 1) return false;
        return true;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearAll();

        const nameEl = document.getElementById('fullName');
        const emailEl = document.getElementById('email');
        const passEl = document.getElementById('password');
        const confirmEl = document.getElementById('confirmPassword');
        const terms = document.getElementById('terms');

        if (!nameEl.value.trim()) {
            setError(nameEl, 'Shkruaj emrin tuaj');
            nameEl.focus();
            return;
        }

        if (!isSimpleEmail(emailEl.value)) {
            setError(emailEl, 'Shkruaj nje email te vlefshem');
            emailEl.focus();
            return;
        }

        if (!passEl.value || passEl.value.length < 8) {
            setError(passEl, 'Fjalekalimi duhet te kete te pakten 8 karaktere');
            passEl.focus();
            return;
        }

        if (passEl.value !== confirmEl.value) {
            setError(confirmEl, 'Fjalekalimet nuk perputhen');
            confirmEl.focus();
            return;
        }

        if (!terms.checked) {
            setError(terms, 'Duhet te pranoni termat');
            return;
        }

        successMessage.textContent = 'Llogaria u krijua me sukses!';
        successMessage.style.display = 'block';
        form.reset();

        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000);
    });
});
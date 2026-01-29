const form = document.getElementById('contactForm');
const submitBtn = form.querySelector('.btn-submit');

form.addEventListener('submit', async function (e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (!name || !email || !message) {
        showMessage('Ju lutem plotësoni të gjitha fushat.', 'error');
        return;
    }
    
    if (message.length < 10) {
        showMessage('Mesazhi duhet të ketë së paku 10 karaktere.', 'error');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Duke dërguar...';
    
    try {
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('message', message);
        
        const response = await fetch('includes/save_contact.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMessage('Faleminderit! Mesazhi u dërgua me sukses.', 'success');
            form.reset();
        } else {
            showMessage(data.message || 'Gabim gjatë dërgimit.', 'error');
        }
    } catch (error) {
        showMessage('Gabim në lidhje me serverin.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Dërgo';
    }
});

function showMessage(text, type) {
    let msgDiv = document.querySelector('.form-message');
    
    if (!msgDiv) {
        msgDiv = document.createElement('div');
        msgDiv.className = 'form-message';
        form.insertBefore(msgDiv, form.firstChild);
    }
    
    msgDiv.textContent = text;
    msgDiv.className = `form-message ${type}`;
    
    setTimeout(() => {
        msgDiv.remove();
    }, 5000);
}

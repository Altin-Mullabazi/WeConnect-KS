const form = document.getElementById('contactForm');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    
    if (name && email && message) {
        alert('Faleminderit! Mesazhi u dergua me sukses.');
        form.reset();
    } else {
        alert('Ju lutem plotsoni te gjitha fushat.');
    }
});
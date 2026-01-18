const slides = document.querySelectorAll('.slide');
let currentSlide = 0;

function showSlide(n) {
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
    }
    if (n >= slides.length) {
        currentSlide = 0;
    }
    if (n < 0) {
        currentSlide = slides.length - 1;
    }
    slides[currentSlide].classList.add('active');
}

function changeSlide(n) {
    currentSlide += n;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
}

window.changeSlide = changeSlide;

setInterval(function() {
    changeSlide(1);
}, 5000);
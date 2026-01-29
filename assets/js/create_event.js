document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('eventForm');
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const dateInput = document.getElementById('event_date');
    const locationInput = document.getElementById('location');
    const categoryInput = document.getElementById('category');

    const previewTitle = document.getElementById('previewTitle');
    const previewDescription = document.getElementById('previewDescription');
    const previewDate = document.getElementById('previewDate');
    const previewLocation = document.getElementById('previewLocation');
    const previewCategory = document.getElementById('previewCategory');

    titleInput.addEventListener('input', function() {
        previewTitle.textContent = this.value || 'Titull i Eventit';
    });

    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Përshkrimi i eventit do të shfaqet këtu...';
    });

    dateInput.addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            const formatter = new Intl.DateTimeFormat('sq-AL', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            previewDate.textContent = formatter.format(date);
        } else {
            previewDate.textContent = 'Data nuk është vendosur';
        }
    });

    locationInput.addEventListener('input', function() {
        previewLocation.textContent = this.value || 'Lokacioni nuk është vendosur';
    });

    categoryInput.addEventListener('change', function() {
        previewCategory.textContent = this.value || 'Kategoria nuk është vendosur';
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const title = titleInput.value.trim();
        const description = descriptionInput.value.trim();
        const eventDate = dateInput.value;
        const location = locationInput.value.trim();
        const category = categoryInput.value;

        const errors = [];

        if (!title || title.length < 3 || title.length > 200) {
            errors.push('Titull duhet të jetë 3-200 karaktere');
        }

        if (!description || description.length < 10 || description.length > 5000) {
            errors.push('Përshkrimi duhet të jetë 10-5000 karaktere');
        }

        if (!eventDate) {
            errors.push('Data e eventit është e detyrueshme');
        } else {
            const selectedDate = new Date(eventDate);
            const now = new Date();
            if (selectedDate <= now) {
                errors.push('Data e eventit duhet të jetë në të ardhmen');
            }
        }

        if (!location || location.length < 3 || location.length > 255) {
            errors.push('Lokacioni duhet të jetë 3-255 karaktere');
        }

        if (!category) {
            errors.push('Kategoria është e detyrueshme');
        }

        if (errors.length > 0) {
            alert('Korrigjeni gabimet:\n\n' + errors.join('\n'));
            return;
        }

        form.submit();
    });

    const today = new Date().toISOString().slice(0, 16);
    dateInput.setAttribute('min', today);
});

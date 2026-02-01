
function toggleCreateGroupModal() {
    const modal = document.getElementById('createGroupModal');
    modal.classList.toggle('show');
    if (modal.classList.contains('show')) {
        document.getElementById('createGroupForm').reset();
    }
}

function closeGroupDetailsModal() {
    document.getElementById('groupDetailsModal').classList.remove('show');
}

function showGroupDetails(name, category, location, members, description, image) {
    document.getElementById('modalGroupName').textContent = name;
    document.getElementById('modalGroupCategory').textContent = category;
    document.getElementById('modalGroupLocation').textContent = location;
    document.getElementById('modalGroupMembers').textContent = members + ' anëtarë';
    document.getElementById('modalGroupDescription').textContent = description;
    document.getElementById('modalGroupImage').src = image;
    document.getElementById('groupDetailsModal').classList.add('show');
}

function handleJoinGroup() {
    alert('Funksioni i bashkimit do të shtohet së shpejti!');
}

async function deleteGroup(id) {
    if (!confirm('A jeni të sigurt që dëshironi të fshini këtë grup?')) {
        return;
    }
    
    try {
        const response = await fetch('delete_group.php?id=' + id);
        const data = await response.json();
        
        if (data.success) {
            alert('Grupi u fshi me sukses!');
            window.location.reload();
        } else {
            alert(data.error || 'Gabim gjatë fshirjes së grupit.');
        }
    } catch (error) {
        alert('Gabim në lidhje me serverin.');
    }
}

async function handleCreateGroup(event) {
    event.preventDefault();
    
    const form = document.getElementById('createGroupForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Duke krijuar...';
    
    try {
        const response = await fetch('create_group.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Grupi u krijua me sukses!');
            toggleCreateGroupModal();
            window.location.reload();
        } else {
            alert(data.error || 'Gabim gjatë krijimit të grupit.');
        }
    } catch (error) {
        alert('Gabim në lidhje me serverin.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = '✅ Krijo Grupin';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle modal close on outside click
    const modals = document.querySelectorAll('.modal');
    window.addEventListener('click', function(event) {
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });
    });

    // Handle btn-join clicks using data attributes
    const joinButtons = document.querySelectorAll('.btn-join');
    joinButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const category = this.getAttribute('data-category');
            const location = this.getAttribute('data-location');
            const members = this.getAttribute('data-members');
            const desc = this.getAttribute('data-desc');
            const image = this.getAttribute('data-image');
            
            if (name) {
                showGroupDetails(name, category, location, members, desc, image);
            }
        });
    });
});

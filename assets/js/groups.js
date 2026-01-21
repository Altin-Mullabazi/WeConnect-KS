
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

function openGroupDetails(groupId) {
    document.getElementById('groupDetailsModal').classList.add('show');
}


function handleCreateGroup(event) {
    event.preventDefault();
    document.getElementById('createGroupForm').submit();
}


document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');
    
    window.addEventListener('click', function(event) {
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });
    });
});

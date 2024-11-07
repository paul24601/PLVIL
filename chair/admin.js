document.querySelectorAll('.chair').forEach(chair => {
    chair.addEventListener('click', function() {
        const chairId = this.getAttribute('data-chair-id');
        const currentStatus = this.classList.contains('occupied') ? 0 : 1;

        // Toggle status visually
        this.classList.toggle('occupied');

        // Update status in the database
        fetch('update-chair-status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ chair_id: chairId, status: currentStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error updating chair status:', data.error);
            }
        })
        .catch(error => console.error('Fetch error:', error));
    });
});

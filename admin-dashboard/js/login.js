function login() {
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;
    const userType = document.getElementById('user-type').value;

    if (!username || !password || !userType) {
        alert("Please fill out all fields.");
        return;
    }

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&userType=${encodeURIComponent(userType)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Store the userType in localStorage and redirect to index.php
            localStorage.setItem('userType', data.userType);
            window.location.href = 'index.php'; // Redirect to index.php directly here
        } else {
            alert('Incorrect username or password.');
        }
    });
}
document.querySelector('.button').addEventListener('click', function(event) {
    event.preventDefault(); // Prevents form submission
    login();
});
localStorage.removeItem('userType'); // Run this in the console or on page load in login.html

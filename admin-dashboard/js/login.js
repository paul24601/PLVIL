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

let attemptCount = localStorage.getItem('attemptCount') ? parseInt(localStorage.getItem('attemptCount')) : 0;
let cooldownStart = localStorage.getItem('cooldownStart') ? parseInt(localStorage.getItem('cooldownStart')) : null;

function displayCooldownTimer() {
    const cooldownElement = document.getElementById('cooldown-timer');
    const cooldownDuration = 60000; // 1 minute in milliseconds
    const now = Date.now();

    if (cooldownStart) {
        const timeLeft = cooldownDuration - (now - cooldownStart);

        if (timeLeft > 0) {
            const secondsLeft = Math.floor(timeLeft / 1000);
            cooldownElement.textContent = `Please wait ${secondsLeft} seconds before trying again.`;
            setTimeout(displayCooldownTimer, 1000); // Update every second
        } else {
            // Reset cooldown
            localStorage.removeItem('cooldownStart');
            localStorage.setItem('attemptCount', '0'); // Reset attempts
            cooldownElement.textContent = ''; // Clear message
        }
    }
}

function login() {
    if (cooldownStart && Date.now() - cooldownStart < 60000) {
        alert("You're on a cooldown. Please wait a minute before trying again.");
        return;
    }

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
            localStorage.setItem('userType', data.userType);
            localStorage.setItem('attemptCount', '0'); // Reset attempts on success
            window.location.href = 'index.php';
        } else {
            attemptCount++;
            localStorage.setItem('attemptCount', attemptCount);

            if (attemptCount >= 3) {
                alert("Too many failed attempts. You are on a 1-minute cooldown.");
                cooldownStart = Date.now();
                localStorage.setItem('cooldownStart', cooldownStart);
                displayCooldownTimer();
            } else {
                alert('Incorrect username or password.');
            }
        }
    });
}

document.querySelector('.button').addEventListener('click', function(event) {
    event.preventDefault();
    login();
});

window.addEventListener('load', () => {
    if (cooldownStart) displayCooldownTimer();
});

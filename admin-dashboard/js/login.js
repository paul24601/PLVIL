// Function to handle login
function login() {
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;
    const userType = document.getElementById('user-type').value;

    // Check if username or password is empty
    if (!username && !password) {
        alert("Please input both username and password.");
        return;
    } else if (!username) {
        alert("Please input a username.");
        return;
    } else if (!password) {
        alert("Please input a password.");
        return;
    } else if (!userType) {
        alert("Please select an admin type.");
        return;
    }

    // Check fixed usernames and passwords for each user type
    if (userType === "admin") {
        if (username === "admin" && password === "iloveplvil") {
            window.location.href = "index.html"; // Redirect to Chairs page
            localStorage.setItem('userType', 'admin'); // Store user type in local storage
        } else {
            alert("Incorrect username or password.");
        }
    } else if (userType === "library-admin") {
        if (username === "libraryadmin" && password === "iloveplvil") {
            window.location.href = "index.html"; // Redirect to index page with all tabs
            localStorage.setItem('userType', 'library-admin'); // Store user type in local storage
        } else {
            alert("Incorrect username or password.");
        }
    } else {
        // Handle invalid selection
        alert("Please select a valid admin type.");
    }
}

// Event listener for login button
document.querySelector('.button').addEventListener('click', function(event) {
    event.preventDefault();
    login();
});

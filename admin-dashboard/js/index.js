
function setupTabs() {
    console.log('setupTabs called');
    const userType = localStorage.getItem('userType');

    // Show all tabs by default
    document.getElementById('books-tab').style.display = 'block';
    document.getElementById('chairs-tab').style.display = 'block';
    document.getElementById('ar-tab').style.display = 'block';

    if (userType === "admin") {
        // Hide Books tab for admin
        document.getElementById('books-tab').style.display = 'none';
        console.log("library-admin");
    } else if (userType === "admin") {
        // No need to change anything for library-admin as all tabs are shown by default
            console.log("library-admin");
    } else {
        // Default case, hide all tabs if no user type is set
        document.getElementById('books-tab').style.display = 'none';
        document.getElementById('chairs-tab').style.display = 'none';
        document.getElementById('ar-tab').style.display = 'none';
    }
}

// Call setupTabs on page load
document.addEventListener('DOMContentLoaded', setupTabs);
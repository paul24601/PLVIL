var toggleBtn = document.getElementById('toggleBtn');
var sideBarIsOpen = true;

toggleBtn.addEventListener('click', (event) => {
    event.preventDefault();

    const sidebar = document.getElementById('sidebar');
    const contentContainer = document.getElementById('contentContainer');
    const userImage = document.getElementById('userImage');
    const menuIcons = document.querySelectorAll('.menu_list i');
    const menuList = document.querySelector('.menu_list');

    if (sideBarIsOpen) {
        sidebar.style.width = '10%'; 
        contentContainer.style.width = '90%'; 
        userImage.style.width = '80px';
        userImage.style.height = '80px'; 
        menuIcons.forEach(icon => {
            icon.style.display = 'none';
        });
        menuList.classList.add('centered');
    } else {
        sidebar.style.width = '20%'; 
        contentContainer.style.width = '80%'; 
        userImage.style.width = '80px';
        userImage.style.height = '80px'; 
        menuIcons.forEach(icon => {
            icon.style.display = 'block';
        });
    }

    sideBarIsOpen = !sideBarIsOpen;
});

// Event listener for Tables and Chairs menu item
document.getElementById('tnc-ad').addEventListener('click', function(event) {
    event.preventDefault();
    console.log('Tables and Chairs menu clicked'); // Check if event listener is triggered
    
    // Remove 'menuActive' class from all menu items
    document.querySelectorAll('.menu_list li').forEach(item => {
        item.classList.remove('menuActive');
    });
    
    // Add 'menuActive' class to the clicked menu item
    this.closest('li').classList.add('menuActive');

    loadContent('tnc-ad.html');
});

// Event listener for Books menu item
document.querySelector('.menu_list li').addEventListener('click', function(event) {
    event.preventDefault();
    console.log('Books menu clicked'); // Check if event listener is triggered
    
    // Remove 'menuActive' class from all menu items
    document.querySelectorAll('.menu_list li').forEach(item => {
        item.classList.remove('menuActive');
    });
    
    // Add 'menuActive' class to the clicked menu item
    this.classList.add('menuActive');

    loadContent('index.php');
});

// Function to load content dynamically
function loadContent(url) {
    const mainContent = document.querySelector('.main_content');
    mainContent.innerHTML = ''; // Clear existing content
    mainContent.innerHTML = `<object type="text/html" data="${url}" style="width: 100%; height: 100%;"></object>`;
}

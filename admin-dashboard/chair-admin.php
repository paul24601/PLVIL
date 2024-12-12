<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['userType'])) {
    header('Location: login.html');
    exit();
}

$userType = $_SESSION['userType'];
$userName = $userType === 'student-admin' ? 'Student Admin' : 'Library Admin';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - PLVIL Admin</title>
    <!-- For High-Resolution Icons -->
    <link rel="icon" href="../assets/plvil-logo.svg" type="image/svg+xml">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">
        <!-- CSS for Minimalistic Button Styling -->
        <style>
            .minimal-btn {
                background: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
                border: none;
                padding: 5px 10px;
                border-radius: 40%;
                color: #000;
                opacity: 0.8; /* Reduced opacity */
                font-size: 1.2em;
                transition: opacity 0.3s;
            }
            .minimal-btn:hover {
                opacity: 1.0; /* Slightly increase opacity on hover */
            }
            /* Chevron when section is expanded */
            a:not(.collapsed) .bi-chevron-down {
                transform: rotate(0deg);
                transition: transform 0.3s ease-in-out;
                /* Add transition */
            }

            /* Chevron when section is collapsed */
            a.collapsed .bi-chevron-down {
                transform: rotate(90deg);
                transition: transform 0.3s ease-in-out;
                /* Add transition */
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const userType = localStorage.getItem('userType');
                if (!userType) {
                    window.location.href = "login.html";
                }
            });
        </script>
    </head>
    <body class="sb-nav-fixed" data-user-type="<?php echo $userType; ?>">
        <!-- Navbar -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">PLVIL Admin</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../index.html">Landing Page</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
                </li>
            </ul>
        </nav>
        
        <!-- side bar -->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <!-- Dashboard -->
                            <div class="sb-sidenav-menu-heading">Main</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <!-- Systems -->
                            <div class="sb-sidenav-menu-heading">Systems</div>

                            <!-- Books Section (Only for Library Admin) -->
                            <a class="nav-link" id="books-section-link" href="book-admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Books
                            </a>
                            </a>
                            
                            <!-- Chairs -->
                            <a class="nav-link" href="chair-admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chair"></i></div>
                                Chairs
                            </a>
                            
                            <!-- AR -->
                            <a class="nav-link" href="ar-admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-eye"></i></div>
                                Augmented Reality
                            </a>
                            
                            <a class="nav-link" href="featured-admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                                Featured Items
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <span id="username"><?php echo $userName; ?></span>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <!-- Floor Plan Section -->
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Chairs Admin</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chairs</li>
                        </ol>

                        <div class="card mb-4 shadow">
                            <div class="card-body">
                                <h3>Library Floor Plan</h3>
                                
                                <!-- Edit Button -->
                                <button class="btn btn-outline-secondary mb-2" onclick="toggleEditMode()">Edit Images</button>
                                
                                <!-- Image Container with Single Bottom Button -->
                                <div class="position-relative text-center mb-3" style="display: inline-block; max-width: 100%;">
                                    <!-- Image Display -->
                                    <img id="floorPlanImage" src="../assets/floor-plan/ground_floor.png?timestamp=<?php echo time(); ?>" alt="Library Floor Plan" style="max-width: 100%; height: auto; position: relative;">
                                    
                                    <!-- Toggle Button (Overlay, Bottom Center) -->
                                    <button id="toggleButton" class="minimal-btn position-absolute" style="bottom: 10px; left: 50%; transform: translateX(-50%);" onclick="toggleImage()">&#9650;</button>
                                </div>
                                
                                <!-- Image Edit Fields (Hidden by Default) -->
                                <div id="editContainer" class="my-3" style="display: none;">
                                    <form action="upload_floorplans.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-2">
                                            <label for="groundFloorImage" class="form-label">Upload Ground Floor Image:</label>
                                            <input type="file" id="groundFloorImage" name="ground-floor" accept="image/*" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label for="secondFloorImage" class="form-label">Upload Second Floor Image:</label>
                                            <input type="file" id="secondFloorImage" name="second-floor" accept="image/*" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            
                                <!-- Tables and Chairs Section -->
                                <h3>
                                    <a class="text-decoration-none text-dark" data-bs-toggle="collapse" href="#collapseTablesAndChairs"
                                    role="button" aria-expanded="false" aria-controls="collapseTablesAndChairs">
                                    Tables and Chairs
                                    <i class="bi bi-chevron-down float-end"></i> <!-- Chevron icon -->
                                    </a>
                                </h3>
                                <div id="collapseTablesAndChairs" class="container-fluid collapse show">
                                    <div id="tables-chairs-container" class="container-fluid"></div>
                                    <button class="btn btn-primary m-2" onclick="addChair('tables-chairs')">Add Chair</button>
                                    <button class="btn btn-danger m-2" onclick="removeChair('tables-chairs')">Remove Chair</button>
                                </div>

                                            
                                <!-- Add a horizontal line to separate sections -->
                                <hr class="my-4"> <!-- Adds some margin space around the horizontal line -->
                            
                                <!-- Computer Seats Section -->
                                <h3>
                                    <a class="text-decoration-none text-dark" data-bs-toggle="collapse" href="#collapseComputerSeats"
                                    role="button" aria-expanded="false" aria-controls="collapseComputerSeats">
                                    Computer Seats
                                    <i class="bi bi-chevron-down float-end"></i> <!-- Chevron icon -->
                                    </a>
                                </h3>
                                <div id="collapseComputerSeats" class="container-fluid collapse show">
                                    <div id="computer-seats-container" class="container-fluid"></div>
                                    <button class="btn btn-primary m-2" onclick="addChair('computer-seats')">Add Computer Seat</button>
                                    <button class="btn btn-danger m-2" onclick="removeChair('computer-seats')">Remove Computer Seat</button>
                                </div>
                                            
                                <!-- Add a horizontal line to separate sections -->
                                <hr class="my-4"> <!-- Adds some margin space around the horizontal line -->
                            
                                <!-- Graduate Study Seats Section -->
                                <h3>
                                    <a class="text-decoration-none text-dark" data-bs-toggle="collapse" href="#collapseGraduatestudySeats"
                                    role="button" aria-expanded="false" aria-controls="collapseGraduatestudySeats">
                                    Graduate Study Seats
                                    <i class="bi bi-chevron-down float-end"></i> <!-- Chevron icon -->
                                    </a>
                                </h3>
                                <div id="collapseGraduatestudySeats"  class="container-fluid collapse show">
                                    <div id="graduate-seats-container" class="container-fluid"></div>
                                    <button class="btn btn-primary m-2" onclick="addChair('graduate-seats')">Add Graduate Study Seat</button>
                                    <button class="btn btn-danger m-2" onclick="removeChair('graduate-seats')">Remove Graduate Study Seat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", loadChairs);
        
            function loadChairs() {
                fetch("chairs.php?action=load&timestamp=${new Date().getTime()}")
                    .then(response => response.json())
                    .then(data => {
                        const sections = {
                            'tables-chairs': document.getElementById("tables-chairs-container"),
                            'computer-seats': document.getElementById("computer-seats-container"),
                            'graduate-seats': document.getElementById("graduate-seats-container"),
                        };

                        const rowLimits = {
                            'tables-chairs': 8,
                            'computer-seats': 9,
                            'graduate-seats': 10,
                        };

                        const icons = {
                            'tables-chairs': '../assets/icons/table.png', // Icon for tables and chairs
                            'computer-seats': '../assets/icons/computer.png', // Icon for computer seats
                            'graduate-seats': '../assets/icons/graduate.png', // Icon for graduate study seats
                        };

                        // Clear all sections
                        Object.values(sections).forEach(section => section.innerHTML = "");

                        // Populate each section with chairs
                        Object.keys(sections).forEach((sectionKey) => {
                            const sectionChairs = data.filter(chair => chair.section === sectionKey);
                            let tableNumber = 1;
                            const rowLimit = rowLimits[sectionKey]; // Get the specific row limit for the section
                            const iconPath = icons[sectionKey]; // Get the specific icon for the section

                            for (let i = 0; i < sectionChairs.length; i += rowLimit) {
                                const tableRow = document.createElement("div");
                                tableRow.classList.add("d-flex", "align-items-center", "mb-4");

                                // Add table icon with number
                                const tableIcon = document.createElement("div");
                                tableIcon.classList.add("me-3", "text-center");
                                tableIcon.innerHTML = `<img src="${iconPath}" alt="Table Icon" style="width: 40px;"> <br> Table ${tableNumber++}`;
                                tableRow.appendChild(tableIcon);

                                // Add chairs to the row
                                const chairsRow = document.createElement("div");
                                chairsRow.classList.add("row", `row-cols-${rowLimit}`, "g-2", "flex-grow-1");

                                sectionChairs.slice(i, i + rowLimit).forEach(chair => {
                                    const button = document.createElement("button");
                                    button.classList.add("btn", "m-1", "col");
                                    button.textContent = `Chair ${chair.seat_number}`;
                                    button.classList.add(chair.status === "occupied" ? "btn-danger" : "btn-success");
                                    button.onclick = () => toggleChair(chair.id);
                                    chairsRow.appendChild(button);
                                });

                                tableRow.appendChild(chairsRow);
                                sections[sectionKey].appendChild(tableRow);
                            }
                        });
                    });
            }


            function toggleChair(id) {
                fetch(`chairs.php?action=toggle&id=${id}`)
                    .then(() => loadChairs());
            }
        
            function addChair(section) {
                fetch(`chairs.php?action=add&section=${section}`)
                    .then(() => loadChairs());
            }
        
            function removeChair(section) {
                fetch(`chairs.php?action=remove&section=${section}`)
                    .then(() => loadChairs());
            }
            
            // Paths to the images
            let currentImageIndex = 0; // Start with the first image (index 0)

// Dynamically generate image paths with a timestamp to prevent caching
const images = [
    `../assets/floor-plan/ground_floor.png?timestamp=${new Date().getTime()}`,
    `../assets/floor-plan/second_floor.png?timestamp=${new Date().getTime()}`
];

// Function to update the displayed image and button icon
function updateImage() {
    document.getElementById("floorPlanImage").src = images[currentImageIndex];
    
    // Update button icon: Down (&#9660;) when on the first image, Up (&#9650;) on the second
    const toggleButton = document.getElementById("toggleButton");
    toggleButton.innerHTML = currentImageIndex === 0 ? "&#9650;" : "&#9660;";
}

// Toggle between the first and second image
function toggleImage() {
    currentImageIndex = currentImageIndex === 0 ? 1 : 0;
    updateImage();
}

            // Toggle edit mode visibility
            function toggleEditMode() {
                const editContainer = document.getElementById("editContainer");
                editContainer.style.display = editContainer.style.display === "none" ? "block" : "none";
            }

            // Preview selected image before saving
            function previewImage(index) {
                const fileInput = index === 0 ? document.getElementById("firstFloorImage") : document.getElementById("secondFloorImage");
                const file = fileInput.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        images[index] = e.target.result;
                        if (currentImageIndex === index) updateImage();
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Save updated images
            function saveImages() {
                toggleEditMode(); // Hide edit mode
                alert("Images updated successfully!"); // Inform the admin
                location.reload(); // Reload the page to reflect changes
            }

            window.onload = function() {
                // Check if the page has already been reloaded once
                if (!sessionStorage.getItem('pageReloaded')) {
                    // Set the flag in sessionStorage to indicate the page has reloaded
                    sessionStorage.setItem('pageReloaded', 'true');
                    // Reload the page
                    window.location.reload();
                }
            };

        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const userType = document.body.getAttribute('data-user-type');

                // Hide the Books section if the user is a student-admin
                if (userType === 'student-admin') {
                    const booksSectionLink = document.getElementById('books-section-link');
                    if (booksSectionLink) {
                        booksSectionLink.style.display = 'none';
                    }
                }
            });
        </script>

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

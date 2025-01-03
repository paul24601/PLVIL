<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "Admin123@plvil";
$dbname = "admin_library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query and search type from the URL
$query = $_GET['query'] ?? '';
$search_type = $_GET['search_type'] ?? 'keyword'; // Default to keyword search

$query = $conn->real_escape_string($query);

// Pagination variables
$results_per_page = 10; // Set how many records per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Get current page number
$start_from = ($page - 1) * $results_per_page; // Calculate the starting record

// Build the SQL query based on search type
switch ($search_type) {
    case 'title':
        $sql_total = "SELECT COUNT(*) AS total FROM book WHERE title LIKE '%$query%'";
        $stmt = $conn->prepare("SELECT * FROM book WHERE title LIKE ? LIMIT ?, ?");
        break;
    case 'author':
        $sql_total = "SELECT COUNT(*) AS total FROM book WHERE author LIKE '%$query%'";
        $stmt = $conn->prepare("SELECT * FROM book WHERE author LIKE ? LIMIT ?, ?");
        break;
    case 'year':
        $sql_total = "SELECT COUNT(*) AS total FROM book WHERE bookYear LIKE '%$query%'";
        $stmt = $conn->prepare("SELECT * FROM book WHERE bookYear LIKE ? LIMIT ?, ?");
        break;
    case 'category':
        $sql_total = "SELECT COUNT(*) AS total FROM book WHERE bookCategory LIKE '%$query%'";
        $stmt = $conn->prepare("SELECT * FROM book WHERE bookCategory LIKE ? LIMIT ?, ?");
        break;
    case 'keyword':
    default:
        $sql_total = "SELECT COUNT(*) AS total FROM book WHERE title LIKE '%$query%' OR author LIKE '%$query%' OR bookYear LIKE '%$query%' OR bookCategory LIKE '%$query%'";
        $stmt = $conn->prepare("SELECT * FROM book WHERE title LIKE ? OR author LIKE ? OR bookYear LIKE ? OR bookCategory LIKE ? LIMIT ?, ?");
        break;
}

// Get total number of results
$total_result = $conn->query($sql_total);
$row = $total_result->fetch_assoc();
$total_records = $row['total'];
$total_pages = ceil($total_records / $results_per_page); // Calculate total pages

// For keyword search, bind all parameters; otherwise, bind only one
$searchQuery = "%$query%";
if ($search_type == 'keyword') {
    $stmt->bind_param('ssssii', $searchQuery, $searchQuery, $searchQuery, $searchQuery, $start_from, $results_per_page);
} else {
    $stmt->bind_param('sii', $searchQuery, $start_from, $results_per_page);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of results from the database (e.g., $total_records is already calculated)
$total_results_displayed = $result->num_rows; // Number of results on the current page

// Close the statement and connection when done
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | PLVIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- For High-Resolution Icons -->
    <link rel="icon" href="assets/plvil-logo.svg" type="image/svg+xml">

    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-image: url(assets/img/books.png);
            background-position: center;
            /* Center the image */
            background-attachment: fixed;
            background-size: cover;
            font-family: 'Roboto', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
        }

        .navbar {
            padding: 0;
        }

        .header-line {
            height: 5px;
            width: 100%;
            margin: auto;
            padding: 0;
        }

        .blue-line {
            background-color: #007bff;
        }

        .black-line {
            background-color: #000;
        }

        .white-line {
            background-color: #e2e2e2;
        }

        /* Initial state */
        .custom-navbar {
            background-color: rgba(255, 255, 255, .9);
            /* Translucent background */
            transition: background-color 0.3s ease-in-out;
            /* Smooth transition */
            backdrop-filter: blur(10px);
        }

        /* Opaque state */
        .custom-navbar.scrolled {
            background-color: rgba(255, 255, 255, .5);
            /* Fully opaque background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .scroll-box {
            max-height: 500px;
            overflow-y: auto;
        }

        .offcanvas {
            background-color: rgba(255, 255, 255, 0.7);
            /* White with 70% opacity */
            backdrop-filter: blur(10px);
            /* Optional: Adds a blur effect to the background */
        }


        .pagination {
            justify-content: center;
        }



        /* Navbar link hover effect */
        .navbar-nav .nav-link {
            transition: transform 0.3s ease;
            /* Smooth transition for scaling */
            padding: 10px 15px;
            /* Ensure spacing around the links */
        }

        .navbar-nav .nav-link:hover {
            transform: scale(1.1);
            /* Slightly increase size on hover */
            font-weight: bold;
            /* Make active link bold */
        }

        /* Active link: Make the active link bold */
        .navbar-nav .nav-link.active {
            font-weight: bold;
            /* Make active link bold */
        }

        .custom-popover .popover-body {
            max-width: 200px;
            /* Adjust this width as needed */
            padding: 10px;
            /* Optional: increase padding */
            font-size: 1.1em;
            /* Optional: increase font size */
            background-color: rgba(255, 255, 255, .5);
            border-radius: 5px;
            border: 0;
        }
    </style>
</head>

<body>
    <!--Header-->
    <div class="container-fluid row header-line">
        <div class="col-4 col-lg-3 black-line"></div>
        <div class="col-4 col-lg-2 white-line"></div>
        <div class="col-4 col-lg-7 blue-line"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md sticky-top custom-navbar">
        <div class="container-fluid px-3 px-md-5 py-2">
            <a href="index.html" class="navbar-brand">
                <span class="fw-bolder text-dark fs-4 d-md-none d-block PLVIL-title">PLVIL</span>
                <span class="fw-bolder text-dark fs-4 d-none d-md-block PLVIL-title">PLV: Interactive Library</span>
            </a>
            <!-- Toggler Button with Font Awesome Icon -->
            <button class="navbar-toggler d-md-none border-0" type="button" data-bs-toggle="popover"
                data-bs-placement="bottom" data-bs-html="true" aria-expanded="false" aria-label="Toggle Navigation">
                <i class="fas fa-bars fa-lg"></i> <!-- Modern hamburger icon -->
            </button>
            <!-- nav -->
            <div class="collapse navbar-collapse justify-content-end align-center d-none d-md-flex" id="main-nav">
                <ul class="navbar-nav">
                    <li class="class-item">
                        <a href="index.html" class="me-4 fs-6 text-dark fw-medium nav-link active">Home</a>
                    </li>
                    <li class="class-item">
                        <a href="#" class="me-4 fs-6 text-dark fw-medium nav-link" data-bs-toggle="modal"
                            data-bs-target="#arModal">AR Scan</a>
                    </li>
                    <li class="class-item">
                        <a href="chairs-user.html" class="me-4 fs-6 text-dark fw-medium nav-link">Chairs</a>
                    </li>
                    <li class="class-item">
                        <a href="about.html" class="me-2 fs-6 text-dark fw-medium nav-link">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- AR Scan Modal -->
    <div class="modal fade" id="arModal" tabindex="-1" aria-labelledby="arModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="arModalLabel">Augmented Reality (AR) Consent Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-box p-3">
                    <p>Dear Users,</p>
                    <p>We are excited to introduce the Augmented Reality (AR) feature as part of the PLVIL: Development
                        of Library Management System with Book Locator and Augmented Reality Assisted Book Viewer for
                        Pamantasan ng Lungsod ng Valenzuela (PLV) University Library. Before you proceed to use this
                        feature, we would like to seek your consent regarding the collection and usage of certain data
                        as required by law.</p>
                    <h3>Explanation of Augmented Reality (AR) Feature:</h3>
                    <p>The AR feature allows users to experience immersive and interactive views of selected library
                        resources through their mobile devices. By accessing this feature, you will be able to visualize
                        additional information, such as book details and related multimedia content, overlaid onto
                        physical objects within the library environment.</p>
                    <h3>Consent for Camera and Speaker Access:</h3>
                    <p>In order to provide you with the AR experience, the PLVIL system requires access to your device's
                        camera and speakers. This access is necessary to enable the AR technology to overlay digital
                        content onto the physical environment and to deliver audiovisual feedback accordingly.</p>
                    <h3>Data Privacy Compliance:</h3>
                    <p>We are committed to protecting your privacy and ensuring compliance with the Data Privacy Act of
                        the Philippines (Republic Act No. 10173) and its implementing rules and regulations. By
                        providing your consent to access your device's camera and speakers for the AR feature, you
                        acknowledge and agree to the following:</p>
                    <ol>
                        <li><strong>Purpose of Data Collection:</strong> The data collected (i.e., images captured by
                            the camera and audio output through the speakers) will be used solely for the purpose of
                            delivering the AR experience within the PLVIL system.</li>
                        <li><strong>Storage and Security:</strong> Any data collected will be stored securely and will
                            not be shared with third parties without your explicit consent, except as required by law.
                        </li>
                        <li><strong>User Control:</strong> You have the right to withdraw your consent at any time by
                            disabling the AR feature in the PLVIL system settings. However, please note that disabling
                            this feature will prevent you from accessing the AR content.</li>
                        <li><strong>Data Retention:</strong> Data collected for the AR feature will be retained only for
                            as long as necessary to fulfill the purposes for which it was collected or as required by
                            applicable laws and regulations.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="acceptBtn">Accept</button>
                    <button type="button" class="btn btn-secondary" id="declineBtn"
                        data-bs-dismiss="modal">Decline</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end d-md-none" tabindex="-1" id="offcanvasMenu"
        aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="class-item">
                    <a href="index.html" class="fs-6 text-dark fw-bold nav-link active">Home</a>
                </li>
                <li class="class-item">
                    <a href="#" class="fs-6 text-dark fw-bold nav-link" data-bs-toggle="modal"
                        data-bs-target="#arModal">AR Scan</a>
                </li>
                <li class="class-item">
                    <a href="admin/chairs-user.html" class="fs-6 text-dark fw-bold nav-link">Chairs</a>
                </li>
                <li class="class-item">
                    <a href="about.html" class="fs-6 text-dark fw-bold nav-link active">About</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Results -->
    <div class="container">
        <div class="mt-5 row justify-content-between align-items-center">
            <h1 class="col-12 col-sm-6 text-light">Search Results</h1>

            <form class="col-12 col-md-6" action="search_results.php" method="GET">
                <!-- Search Section with Dropdown and Input -->
                <div class="col-md col-12 d-flex py-2 px-0 flex-column">
                    <!-- Dropdown for Search Type -->
                    <div class="input-group">
                        <select class="form-select" name="search_type" id="searchType" aria-label="Search Type">
                            <option value="keyword">Keyword</option>
                            <option value="title">Title</option>
                            <option value="author">Author</option>
                            <option value="year">Year</option>
                            <option value="category">Category</option>
                        </select>

                        <!-- Search Input Field -->
                        <input type="text" style="width: 40%;" name="query" id="searchQuery" class="form-control"
                            placeholder="Enter search term" required>

                        <!-- Search Button -->
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                </div>
            </form>
        </div>

        <!-- Show "Showing X results out of Y books for 'query'" -->
        <p class="text-light">Showing <?php echo $total_results_displayed; ?> results out of
            <?php echo $total_records; ?> books for "<?php echo htmlspecialchars($query); ?>"
        </p>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-12 mb-2">
                        <a href="bookloc.html?bookId=<?php echo htmlspecialchars($row['bookId']); ?>"
                            class="text-decoration-none text-reset">
                            <div class="card h-100"
                                style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px);">
                                <!-- Adjust the RGBA values for your desired color and opacity -->
                                <div class="row g-0">
                                    <!-- Book Cover -->
                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                        <img src="<?php echo !empty($row['image2']) ? "../admin/uploads/" . htmlspecialchars($row['image2']) : 'default-cover.jpg'; ?>"
                                            class="img-fluid rounded shadow" alt="Book Cover"
                                            style="width: 90%; height: 200px; object-fit: cover; max-height: 200px; margin: 10px;">
                                    </div>
                                    <!-- Book Details -->
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                                            <p class="card-text"><strong>Author:</strong>
                                                <?php echo htmlspecialchars($row['Author']); ?></p>
                                            <p class="card-text"><strong>Year:</strong>
                                                <?php echo htmlspecialchars($row['bookYear']); ?></p>
                                            <p class="card-text"><strong>Category:</strong>
                                                <?php echo htmlspecialchars($row['bookCategory']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>




            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?query=<?php echo $query; ?>&page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?query=<?php echo $query; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?query=<?php echo $query; ?>&page=<?php echo $page + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php else: ?>
            <div class="alert alert-warning">No results found for "<?php echo htmlspecialchars($query); ?>"</div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted mt-5 pt-1">
        <!-- Section: Links -->
        <section class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <!-- About -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mx-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-book me-3"></i>PLV: Interactive Library
                    </h6>
                    <p>
                        The PLVIL project brings the library closer to students through interactive tools like AR,
                        making knowledge more accessible.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Quick Links</h6>
                    <p><a href="index.html" class="text-reset">Home</a></p>
                    <p><a href="about.html" class="text-reset">About</a></p>
                    <p><a href="search_results.php?search_type=keyword&query=+" class="text-reset">Browse Books</a></p>
                    <p><a href="#" class="text-reset" data-bs-toggle="modal" data-bs-target="#arModal">AR Scan</a></p>
                </div>

                <!-- Contact -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fas fa-home me-3"></i>Maysan, Valenzuela, Philippines</p>
                    <!-- Gmail Link (using mailto for email link) -->
                    <p>
                        <a href="mailto:plvlibrarymain@gmail.com" class="me-4 text-reset text-decoration-none">
                            <i class="fas fa-envelope me-3"></i>plvlibrarymain@gmail.com
                        </a>
                    </p>
                    <p><i class="fas fa-phone me-3"></i>8352-700 Loc. 134, 135</p>
                    <!-- Facebook Link -->
                    <p>
                        <a href="https://www.facebook.com/profile.php?id=100064626706651" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-facebook-f me-3"></i>Pamantasan ng Lungsod ng Valenzuela University Library
                        </a>
                    </p>
                </div>
            </div>
        </section>

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-reset fw-bold" href="#">PLV: Interactive Library</a>
        </div>
    </footer>

    <!-- custom navbar -->
    <script>
        // Add a scroll event listener
        window.addEventListener('scroll', function () {
            // Select the navbar
            var navbar = document.querySelector('.custom-navbar');

            // Add or remove the 'scrolled' class based on scroll position
            if (window.scrollY > 10) { // Adjust the value '50' as needed
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <!-- popover navbar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navContent = `
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link text-dark">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" id="arScanButton" class="nav-link text-dark">
                            <i class="fas fa-camera me-2"></i>AR Scan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chairs-user.html" class="nav-link text-dark">
                            <i class="fas fa-chair me-2"></i>Chairs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="about.html" class="nav-link text-dark">
                            <i class="fas fa-info-circle me-2"></i>About
                        </a>
                    </li>
                </ul>
            `;

            const popoverTrigger = document.querySelector('[data-bs-toggle="popover"]');
            const popover = new bootstrap.Popover(popoverTrigger, {
                content: navContent,
                html: true,
                container: 'body',
                customClass: 'custom-popover'
            });

            // Track popover visibility
            let popoverVisible = false;

            popoverTrigger.addEventListener('click', function () {
                popoverVisible = !popoverVisible; // Toggle visibility flag
            });

            document.addEventListener('click', function (e) {
                // Hide popover on next click outside of the popoverTrigger if it is visible
                if (popoverVisible && !popoverTrigger.contains(e.target)) {
                    popover.hide();
                    popoverVisible = false; // Reset visibility flag
                }
            });

            // Event listener to open the modal
            document.addEventListener('click', function (e) {
                if (e.target && e.target.id === 'arScanButton') {
                    const arModal = new bootstrap.Modal(document.getElementById('arModal'));
                    arModal.show();
                }
            });
        });

    </script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle Accept button click
            document.getElementById('acceptBtn').addEventListener('click', function () {
                // Show confirmation message
                alert('Thank you for your cooperation and participation in the PLVIL project. If you have any questions or concerns regarding this consent form or the AR feature, please do not hesitate to contact us.');

                // Redirect to AR scan page after a short delay
                setTimeout(function () {
                    window.location.href = 'AR/ar-scan.html';
                }, 1000); // Delay of 1 second
            });

            // Handle Decline button click (close modal by default)
            document.getElementById('declineBtn').addEventListener('click', function () {
                $('#arModal').modal('hide');
            });
        });
    </script>
</body>

</html>
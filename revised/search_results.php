<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL
$query = $_GET['query'] ?? '';
$query = $conn->real_escape_string($query);

// Pagination variables
$results_per_page = 12; // Set how many records per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Get current page number
$start_from = ($page - 1) * $results_per_page; // Calculate the starting record

// Get total number of results
$sql_total = "SELECT COUNT(*) AS total FROM book WHERE title LIKE '%$query%' OR author LIKE '%$query%'";
$total_result = $conn->query($sql_total);
$row = $total_result->fetch_assoc();
$total_records = $row['total'];
$total_pages = ceil($total_records / $results_per_page); // Calculate total pages

// Use prepared statements to prevent SQL injection and apply pagination with LIMIT
$stmt = $conn->prepare("SELECT * FROM book WHERE title LIKE ? OR author LIKE ? LIMIT ?, ?");
$searchQuery = "%$query%";
$stmt->bind_param('ssii', $searchQuery, $searchQuery, $start_from, $results_per_page);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of results from the database (e.g., $total_records is already calculated)
$total_results_displayed = $result->num_rows; // Number of results on the current page

// Close the statement when done
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(assets/img/books.png);
            background-position: center;
            /* Center the image */
            background-attachment: fixed;
            background-size: cover;
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

        .custom-navbar {
            background-color: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            /* Optional: Adds a blur effect to the background */
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
        <div class="container-lg">
            <a href="index.html" class="navbar-brand">
                <span class="fw-bold text-dark fs-5 d-lg-none d-block PLVIL-title">PLVIL</span>
                <span class="fw-bold text-dark fs-5 d-none d-lg-block PLVIL-title">PLV: Interactive Library</span>
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler d-md-none p-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-expanded="false"
                aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-center d-none d-md-flex" id="main-nav">
                <ul class="navbar-nav">
                    <li class="class-item">
                        <a href="index.html" class="ms-3 fs-6 text-dark fw-bold nav-link active">Home</a>
                    </li>
                    <li class="class-item">
                        <a href="#" class="fs-6 text-dark fw-bold nav-link" data-bs-toggle="modal"
                            data-bs-target="#arModal">AR Scan</a>
                    </li>
                    <li class="class-item">
                        <a href="library-seat-viewer/CHAIRS/chairs-user.html"
                            class="fs-6 text-dark fw-bold nav-link">Chairs</a>
                    </li>
                    <li class="class-item">
                        <a href="about.html" class="fs-6 text-dark fw-bold nav-link active">About</a>
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
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav text-start">
                <li class="nav-item">
                    <a class="nav-link text-dark active" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" data-bs-toggle="modal" data-bs-target="#arModal">AR
                        Scan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="library-seat-viewer/CHAIRS/chairs-user.html">Chairs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="about.html">About</a>
                </li>
            </ul>
        </div>
    </div>

    <!--Search results section-->
    <div class="container my-5">
        <h2>Search Results</h2>
        <div class="d-flex flex-column align-items-center">
            <div class="input-group mb-4 w-100">
                <input type="text" class="form-control me-2" value="<?php echo htmlspecialchars($query); ?>" id="search-query" name="query" placeholder="Search for books..." aria-label="Search for books">
                <button class="btn btn-primary" onclick="performSearch()">Search</button>
            </div>

            <!-- Pagination navigation -->
            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link"
                            href="search.php?query=<?php echo $query; ?>&page=<?php echo ($page - 1); ?>">Previous</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="search.php?query=<?php echo $query; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link"
                            href="search.php?query=<?php echo $query; ?>&page=<?php echo ($page + 1); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- Results display -->
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="path_to_image/<?php echo $row['image_path']; ?>" class="card-img-top" alt="Book image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo $row['author']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!--Footer-->
    <footer class="text-center mt-auto py-4">
        <p>&copy; 2024 PLVIL: Interactive Library. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("acceptBtn").addEventListener("click", function () {
            window.location.href = "AR/ar-scan.html";
        });

        function performSearch() {
            const query = document.getElementById("search-query").value;
            window.location.href = "search.php?query=" + encodeURIComponent(query);
        }
    </script>
</body>

</html>

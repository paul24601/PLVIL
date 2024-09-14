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
$query = $_GET['query'];

// Sanitize the input
$query = $conn->real_escape_string($query);

// Prepare the SQL statement
$sql = "SELECT * FROM book WHERE title LIKE '%$query%' OR author LIKE '%$query%'";

// Execute the query
$result = $conn->query($sql);
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
                        <a href="#" class="fs-6 text-dark fw-bold nav-link" data-bs-toggle="modal" data-bs-target="#arModal">AR Scan</a>
                    </li>
                    <li class="class-item">
                        <a href="library-seat-viewer/CHAIRS/chairs-user.html" class="fs-6 text-dark fw-bold nav-link">Chairs</a>
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
                    <p>We are excited to introduce the Augmented Reality (AR) feature as part of the PLVIL: Development of Library Management System with Book Locator and Augmented Reality Assisted Book Viewer for Pamantasan ng Lungsod ng Valenzuela (PLV) University Library. Before you proceed to use this feature, we would like to seek your consent regarding the collection and usage of certain data as required by law.</p>
                    <h3>Explanation of Augmented Reality (AR) Feature:</h3>
                    <p>The AR feature allows users to experience immersive and interactive views of selected library resources through their mobile devices. By accessing this feature, you will be able to visualize additional information, such as book details and related multimedia content, overlaid onto physical objects within the library environment.</p>
                    <h3>Consent for Camera and Speaker Access:</h3>
                    <p>In order to provide you with the AR experience, the PLVIL system requires access to your device's camera and speakers. This access is necessary to enable the AR technology to overlay digital content onto the physical environment and to deliver audiovisual feedback accordingly.</p>
                    <h3>Data Privacy Compliance:</h3>
                    <p>We are committed to protecting your privacy and ensuring compliance with the Data Privacy Act of the Philippines (Republic Act No. 10173) and its implementing rules and regulations. By providing your consent to access your device's camera and speakers for the AR feature, you acknowledge and agree to the following:</p>
                    <ol>
                        <li><strong>Purpose of Data Collection:</strong> The data collected (i.e., images captured by the camera and audio output through the speakers) will be used solely for the purpose of delivering the AR experience within the PLVIL system.</li>
                        <li><strong>Storage and Security:</strong> Any data collected will be stored securely and will not be shared with third parties without your explicit consent, except as required by law.</li>
                        <li><strong>User Control:</strong> You have the right to withdraw your consent at any time by disabling the AR feature in the PLVIL system settings. However, please note that disabling this feature will prevent you from accessing the AR content.</li>
                        <li><strong>Data Retention:</strong> Data collected for the AR feature will be retained only for as long as necessary to fulfill the purposes for which it was collected or as required by applicable laws and regulations.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="acceptBtn">Accept</button>
                    <button type="button" class="btn btn-secondary" id="declineBtn" data-bs-dismiss="modal">Decline</button>
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
                    <a href="#" class="fs-6 text-dark fw-bold nav-link" data-bs-toggle="modal" data-bs-target="#arModal">AR Scan</a>
                </li>
                <li class="class-item">
                    <a href="Admin/chairs-user.html" class="fs-6 text-dark fw-bold nav-link">Chairs</a>
                </li>
                <li class="class-item">
                    <a href="about.html" class="fs-6 text-dark fw-bold nav-link active">About</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Results -->
    <div class="container mt-5">
        <h1 class="text-light p-3 rounded">Search Results</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-4 position-relative">
                    <div class="row g-0">
                        <!-- Left part: Cover Image -->
                        <div class="col-md-4">
                            <?php if (!empty($row['image2'])): ?>
                                <img src="../Admin/uploads/<?php echo htmlspecialchars($row['image2']); ?>" class="img-fluid rounded-start" alt="Cover Page" style="width: 100%; height: auto;">
                            <?php else: ?>
                                <img src="default-cover.jpg" class="img-fluid rounded-start" alt="No Cover Available" style="width: 100%; height: auto;">
                            <?php endif; ?>
                        </div>
                        <!-- Right part: Book Details -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                                <p class="card-text">
                                    <strong>Author:</strong>
                                    <a href="bookloc.html?bookId=<?php echo htmlspecialchars($row['bookId']); ?>" class="text-decoration-none stretched-link text-black fw-semibold">
                                        <?php echo htmlspecialchars($row['Author']); ?>
                                    </a>
                                </p>
                                <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($row['bookCategory']); ?></p>
                                <p class="card-text"><strong>Book ID:</strong> <?php echo htmlspecialchars($row['bookId']); ?></p>
                                <p class="card-text"><strong>Column Number:</strong> <?php echo htmlspecialchars($row['columnNumber']); ?></p>
                                <p class="card-text"><strong>Accession:</strong> <?php echo htmlspecialchars($row['Accession']); ?></p>
                                <p class="card-text"><strong>Edition:</strong> <?php echo htmlspecialchars($row['bookEdition']); ?></p>
                                <p class="card-text"><strong>Year:</strong> <?php echo htmlspecialchars($row['bookYear']); ?></p>
                                <p class="card-text"><strong>Property:</strong> <?php echo htmlspecialchars($row['Property']); ?></p>
                                <p class="card-text"><strong>Call Number:</strong> <?php echo htmlspecialchars($row['CallNumber']); ?></p>
                                <p class="card-text"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                No results found for "<?php echo htmlspecialchars($query); ?>".
            </div>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>




    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted mt-5">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Right -->
            <div>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </section>
        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>PLV: Interactive Library
                        </h6>
                        <p>
                            The PLVIL project brings the library closer to students through interactive tools like AR, making knowledge more accessible.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Quick Links
                        </h6>
                        <p>
                            <a href="index.html" class="text-reset">Home</a>
                        </p>
                        <p>
                            <a href="about.html" class="text-reset">About</a>
                        </p>
                        <p>
                            <a href="browse.html" class="text-reset">Browse Books</a>
                        </p>
                        <p>
                            <a href="#" class="text-reset" data-bs-toggle="modal" data-bs-target="#arModal">AR Scan</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6>
                        <p>
                            <a href="terms.html" class="text-reset">Terms of Service</a>
                        </p>
                        <p>
                            <a href="privacy.html" class="text-reset">Privacy Policy</a>
                        </p>
                        <p>
                            <a href="#" class="text-reset">Support</a>
                        </p>
                        <p>
                            <a href="#" class="text-reset">Help</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> Valenzuela City, Metro Manila</p>
                        <p><i class="fas fa-envelope me-3"></i> library@plvil.ph</p>
                        <p><i class="fas fa-phone me-3"></i> + 63 123 456 7890</p>
                        <p><i class="fas fa-print me-3"></i> + 63 123 456 7891</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-reset fw-bold" href="#">PLV: Interactive Library</a>
        </div>
    </footer>
    <!-- Footer -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
        // Handle Accept button click
        document.getElementById('acceptBtn').addEventListener('click', function () {
            // Show confirmation message
            alert('Thank you for your cooperation and participation in the PLVIL project. If you have any questions or concerns regarding this consent form or the AR feature, please do not hesitate to contact us.');
            
            // Redirect to AR scan page after a short delay
            setTimeout(function() {
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

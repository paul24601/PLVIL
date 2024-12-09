<?php
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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    
    <!-- For High-Resolution Icons -->
    <link rel="icon" href="assets/plvil-logo.svg" type="image/svg+xml">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: block;
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
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../index.html">Landing Page</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                </ul>
            </li>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Augmented Reality Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Augmented Reality</li>
                    </ol>
                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <div class="container-fluid mb-3">
                                <h2>Upload Images for Book Elements</h2>
                                <form action="../AR/upload.php" method="POST" enctype="multipart/form-data">
                                    <!-- Book Title Image Input -->
                                    <div class="mb-3">
                                        <label for="book1-title" class="form-label">Book Title Image</label>
                                        <input type="file" id="book1-title" name="book1-title"
                                            class="form-control short-input" accept=".png">
                                        <small class="text-muted">Only PNG files are supported.</small>
                                        <img id="book1-title-preview" class="preview-img" src="#"
                                            alt="Book Title Image Preview" style="display: none;">
                                        <div id="book1-title-error" class="text-danger" style="display:none;">Please
                                            upload a valid PNG file.</div>
                                    </div>

                                    <!-- Author Image Input -->
                                    <div class="mb-3">
                                        <label for="book1-auth" class="form-label">Author Image</label>
                                        <input type="file" id="book1-auth" name="book1-auth"
                                            class="form-control short-input" accept=".png">
                                        <small class="text-muted">Only PNG files are supported.</small>
                                        <img id="book1-auth-preview" class="preview-img" src="#"
                                            alt="Author Image Preview" style="display: none;">
                                        <div id="book1-auth-error" class="text-danger" style="display:none;">Please
                                            upload a valid PNG file.</div>
                                    </div>

                                    <!-- Genre Image Input -->
                                    <div class="mb-3">
                                        <label for="book1-gen" class="form-label">Genre Image</label>
                                        <input type="file" id="book1-gen" name="book1-gen"
                                            class="form-control short-input" accept=".png">
                                        <small class="text-muted">Only PNG files are supported.</small>
                                        <img id="book1-gen-preview" class="preview-img" src="#"
                                            alt="Genre Image Preview" style="display: none;">
                                        <div id="book1-gen-error" class="text-danger" style="display:none;">Please
                                            upload a valid PNG file.</div>
                                    </div>

                                    <!-- Synopsis Image Input -->
                                    <div class="mb-3">
                                        <label for="book1-syn" class="form-label">Synopsis Image</label>
                                        <input type="file" id="book1-syn" name="book1-syn"
                                            class="form-control short-input" accept=".png">
                                        <small class="text-muted">Only PNG files are supported.</small>
                                        <img id="book1-syn-preview" class="preview-img" src="#"
                                            alt="Synopsis Image Preview" style="display: none;">
                                        <div id="book1-syn-error" class="text-danger" style="display:none;">Please
                                            upload a valid PNG file.</div>
                                    </div>

                                    <!-- Language Image Input -->
                                    <div class="mb-3">
                                        <label for="book1-lang" class="form-label">Language Image</label>
                                        <input type="file" id="book1-lang" name="book1-lang"
                                            class="form-control short-input" accept=".png">
                                        <small class="text-muted">Only PNG files are supported.</small>
                                        <img id="book1-lang-preview" class="preview-img" src="#"
                                            alt="Language Image Preview" style="display: none;">
                                        <div id="book1-lang-error" class="text-danger" style="display:none;">Please
                                            upload a valid PNG file.</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Upload Images</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- JavaScript Validation Script -->
    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function () {
                const file = this.files[0];
                const preview = document.getElementById(`${this.id}-preview`);
                const error = document.getElementById(`${this.id}-error`);

                // Hide previous error messages
                error.style.display = 'none';

                if (file) {
                    // Check if the file is a PNG
                    if (file.type !== 'image/png') {
                        // Show error message if not a PNG
                        error.textContent = 'Please upload a valid PNG file.';
                        error.style.display = 'block';
                        this.value = '';  // Clear the input
                        preview.src = '#';
                        preview.style.display = 'none';
                    } else {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function () {
                const file = this.files[0];
                const preview = document.getElementById(`${this.id}-preview`);

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }

                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        });


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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
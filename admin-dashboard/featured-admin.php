<?php
session_start();
if (!isset($_SESSION['userType'])) {
    header('Location: login.html');
    exit();
}

$userType = $_SESSION['userType'];
$userName = $userType === 'student-admin' ? 'Student Admin' : 'Library Admin';
?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Admin123@plvil";
$dbname = "admin_library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add, Edit, and Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $additional_info = $_POST['additional_info'];
    $image_url = $_POST['image_url'] ?? '';
    $more_info_link = $_POST['more_info_link'];

    // Check if a file is uploaded
   if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2 MB

    $file_type = mime_content_type($_FILES['image_file']['tmp_name']);
    $file_size = $_FILES['image_file']['size'];

    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    if ($file_size > $max_size) {
        die("File is too large. Maximum size is 2 MB.");
    }

    $upload_dir = '/assets/uploads/';
    $absolute_upload_dir = $_SERVER['DOCUMENT_ROOT'] . $upload_dir;

    if (!is_dir($absolute_upload_dir)) {
        mkdir($absolute_upload_dir, 0777, true);
    }

    $file_name = basename($_FILES['image_file']['name']);
    $file_path = $absolute_upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $file_path)) {
        $image_url = $upload_dir . $file_name; // Use relative path for the URL
    } else {
        die("Failed to move uploaded file.");
    }
}

    if (isset($_POST['add'])) {
        $conn->query("INSERT INTO featured_items (title, summary, image_url, additional_info, more_info_link) 
                      VALUES ('$title', '$summary', '$image_url', '$additional_info', '$more_info_link')");
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'] ?? null; // Use null coalescing operator to avoid errors
        if ($id) { // Ensure $id is not null
            $conn->query("UPDATE featured_items SET title='$title', summary='$summary', image_url='$image_url', additional_info='$additional_info', more_info_link='$more_info_link' WHERE id='$id'");
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM featured_items WHERE id='$id'");
    }
    header("Location: featured-admin.php");
    exit();
}

// Fetch featured items
$sql = "SELECT * FROM featured_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Featured Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

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
    <link rel="icon" href="../assets/plvil-logo.svg" type="image/svg+xml">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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

                        <!-- Other sections -->
                        <a class="nav-link" href="chair-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chair"></i></div>
                            Chairs
                        </a>

                        <a class="nav-link" href="ar-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-eye"></i></div>
                            Augmented Reality
                        </a>
                        
                        <!-- Archive -->                         

                        <a class="nav-link" href="featured-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                            Featured Items
                        </a>                        
<a class="nav-link" href="archived-books.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-archive"></i></div>
                            Archive
                        </a>
                    </div>
                </div>

                <!-- Footer with Dynamic Username -->
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <span id="username"><?php echo $userName; ?></span>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Featured Items Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Featured Items</li>
                    </ol>

                    <!-- Add/Edit Item Form -->
                    <div class="card mb-4 shadow">
                        <div class="card-header">Add or Edit Featured Item</div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" class="row g-3">
                                <!-- Title, Summary, and other input fields remain the same -->
                                <div class="col-md-4">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="image_url" class="form-label">Image URL</label>
                                    <input type="text" class="form-control" id="image_url" name="image_url">
                                </div>
                                <div class="col-md-4">
                                    <label for="image_file" class="form-label">Or Upload Image File</label>
                                    <input type="file" class="form-control" id="image_file" name="image_file"
                                        accept="image/*">
                                </div>
                                <div class="col-12">
                                    <label for="summary" class="form-label">Summary</label>
                                    <textarea class="form-control" id="summary" name="summary" rows="3"
                                        required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="additional_info" class="form-label">Additional Info</label>
                                    <textarea class="form-control" id="additional_info" name="additional_info"
                                        rows="3"></textarea>
                                </div>
                                <!-- Add this input field in the existing form in the admin panel -->
                                <div class="col-12">
                                    <label for="more_info_link" class="form-label">More Info Link</label>
                                    <input type="text" class="form-control" id="more_info_link" name="more_info_link"
                                        placeholder="https://example.com">
                                </div>
                                <!-- Add Button (Visible by Default) -->
                                <div class="col-12">
                                    <button type="submit" name="add" class="btn btn-primary" id="addButton">Add Featured
                                        Item</button>
                                </div>

                                <!-- Edit Button (Visible when editing) -->
                                <div class="col-12">
                                    <button type="submit" name="edit" class="btn btn-warning" id="editButton"
                                        style="display:none;">Update Featured Item</button>
                                    <!-- Cancel Edit Button -->
                                    <button type="button" class="btn btn-secondary" id="cancelEditButton"
                                        style="display:none;" onclick="resetForm()">Cancel Edit</button>
                                    <!-- Hidden ID field for Edit action -->
                                    <input type="hidden" name="id" id="hiddenId">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Featured Items Table -->
                    <div class="card shadow">
                        <div class="card-header">Current Featured Items</div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-striped mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Summary</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Additional Info</th>
                                        <th scope="col">More Info Link</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                                            <td><?php echo htmlspecialchars($row['summary']); ?></td>
                                            <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                                                    alt="<?php echo htmlspecialchars($row['title']); ?>"
                                                    style="height: 50px;"></td>
                                            <td><?php echo htmlspecialchars($row['additional_info']); ?></td>
                                            <td>
                                                <a href="<?php echo htmlspecialchars($row['more_info_link']); ?>" target="_blank">
                                                    <?php echo htmlspecialchars($row['more_info_link']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <!-- Edit and Delete Actions -->
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="delete"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; PLVIL Admin 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script>
        function populateEditForm(item) {
            // Populate form fields with the item data
            document.getElementById('title').value = item.title;
            document.getElementById('summary').value = item.summary;
            document.getElementById('image_url').value = item.image_url;
            document.getElementById('additional_info').value = item.additional_info;
            document.getElementById('more_info_link').value = item.more_info_link;

            // Set hidden ID field for the edit action
            document.getElementById('hiddenId').value = item.id;

            // Hide the Add button and show the Edit and Cancel Edit buttons
            document.getElementById('addButton').style.display = 'none';
            document.getElementById('editButton').style.display = 'block';
            document.getElementById('cancelEditButton').style.display = 'block';

            const form = document.querySelector('form');
            form.action = 'featured-admin.php';
            const addButton = document.querySelector('[name="add"]');
            addButton.setAttribute('name', 'edit');
            addButton.innerHTML = 'Update Featured Item';

            let hiddenId = document.getElementById('hiddenId');
            if (!hiddenId) {
                hiddenId = document.createElement('input');
                hiddenId.type = 'hidden';
                hiddenId.id = 'hiddenId';
                hiddenId.name = 'id';
                form.appendChild(hiddenId);
            }
            hiddenId.value = item.id;
        }

        // Optionally, a reset function to prepare form for new entry
        function resetForm() {
            // Clear the form fields
            document.getElementById('title').value = '';
            document.getElementById('summary').value = '';
            document.getElementById('image_url').value = '';
            document.getElementById('additional_info').value = '';
            document.getElementById('more_info_link').value = '';
            document.getElementById('hiddenId').value = '';

            // Show the Add button and hide the Edit and Cancel Edit buttons
            document.getElementById('addButton').style.display = 'block';
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('cancelEditButton').style.display = 'none';
        }

    </script>
    
    <!-- hide books admin -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/classes/Book.php';
$db = new DBConnection();
?>
<?php
session_start();
if (!isset($_SESSION['userType'])) {
    header('Location: login.html');
    exit();
}

$userType = $_SESSION['userType'];
if ($userType === 'student-admin') {
    header('Location: index.php?warning=restricted'); // Redirect with warning
    exit();
}

$userName = $userType === 'student-admin' ? 'Student Admin' : 'Library Admin';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard - PLVIL Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- For High-Resolution Icons -->
    <link rel="icon" href="../assets/plvil-logo.svg" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Load other JS libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
    $("#bookCategoryInput").autocomplete({
        source: function (request, response) {
            console.log("Requesting autocomplete for:", request.term); // Debugging
            $.ajax({
                url: '/admin/classes/fetchCategories.php', // Endpoint
                dataType: 'json',
                data: { term: request.term }, // User's input
                success: function (data) {
                    console.log("Autocomplete suggestions:", data); // Debugging
                    response(data); // Pass suggestions to autocomplete
                },
                error: function () {
                    console.error("Failed to fetch categories.");
                }
            });
        },
        minLength: 1, // Start after 1 characters
        select: function (event, ui) {
            console.log("Selected item:", ui.item.value); // Log selected item
        }
    });


});
    </script>


    <style>
        #datatablesSimple_length {
            margin-bottom: 20px;
        }

        .add-book-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            width: 40px;
            /* Square width */
            height: 40px;
            /* Square height */
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: width 0.3s ease, padding 0.3s ease;
            /* Transition for smooth expansion */
            overflow: hidden;
        }

        /* Hide text initially */
        .add-book-button .add-text {
            opacity: 0;
            max-width: 0;
            white-space: nowrap;
            margin-left: 8px;
            transition: opacity 0.3s ease, max-width 0.3s ease;
        }

        /* Expand button and reveal text on hover */
        .add-book-button:hover {
            width: auto;
            /* Expands width to fit content */
            padding: 8px 12px;
        }

        .add-book-button:hover .add-text {
            opacity: 1;
            max-width: 100px;
            /* Set a maximum width for the text */
        }

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 9999 !important;
            /* Ensure it appears above modal */
            background-color: white;
            /* Match the modal's background color */
            border: 1px solid #ccc;
            padding: 5px;
        }
.dropdown-menu {
    z-index: 1055; /* Ensure dropdown appears above other elements */
}

.sb-topnav {
    position: relative; /* Prevents dropdown from being clipped */
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
            <div class="input-group">
            </div>
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
                        <!-- Books -->
                        <a class="nav-link" href="book-admin.php">
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
                    <h1 class="mt-4">Book Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Books</li>
                    </ol>


                    <div class="add-book">
                        <button class="btn btn-success btn-md add-book-button" data-bs-toggle="modal"
                            data-bs-target="#addBook">
                            <i class="fa-solid fa-plus ps-2"></i>
                            <span class="add-text">Add New Book</span>
                        </button>
                    </div>

                    <!-- table -->
                    <div class="card mb-4 shadow">
                        <div class="card-body">

                            <!-- Table Section -->
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered display nowrap border"
                                    id="datatablesSimple">
                                    <thead class="table-bordered table-light">
                                        <tr>
                                            <th class="text-center" width="5%">Book ID</th>
                                            <th class="text-center" width="10%">Category</th>
                                            <th class="text-center" width="10%">Book Stem</th>
                                            <th class="text-center" width="10%">Front Cover</th>
                                            <th class="text-center" width="10%">Title</th>
                                            <th class="text-center" width="10%">Author</th>
                                            <th class="text-center" width="10%">Shelves Number</th>
                                            <th class="text-center" width="10%">Accession</th>
                                            <th class="text-center" width="10%">Edition</th>
                                            <th class="text-center" width="10%">Year</th>
                                            <th class="text-center" width="10%">Property</th>
                                            <th class="text-center" width="10%">Call Number</th>
                                            <th class="text-center" width="10%">ISBN/ISSN</th>
                                            <th class="text-center" width="10%">Manage Book</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                        $bookObj = new book();
                                        $books = $bookObj->getAllBooks();
                                        $no = 0;
                                        foreach ($books as $book):
                                            $no++;
                                            ?>
                                            <tr>
                                                <td><?php echo $book['bookId']; ?></td> <!-- Display the Book ID -->
                                                <td><?php echo $book['bookCategory']; ?></td>
                                                <td><img src="/admin/uploads/<?php echo $book['image1']; ?>" alt="Book Stem"
                                                        style="width: 100px; height: 100px;"></td>
                                                <td><img src="/admin/uploads/<?php echo $book['image2']; ?>"
                                                        alt="Front Cover" style="width: 100px; height: 100px;"></td>
                                                <td><?php echo $book['Title']; ?></td>
                                                <td><?php echo $book['Author']; ?></td>
                                                <td><?php echo $book['columnNumber']; ?></td>
                                                <td><?php echo $book['Accession']; ?></td>
                                                <td><?php echo $book['bookEdition']; ?></td>
                                                <td><?php echo $book['bookYear']; ?></td>
                                                <td><?php echo $book['Property']; ?></td>
                                                <td><?php echo $book['CallNumber']; ?></td>
                                                <td><?php echo $book['isbn']; ?></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm editButton"
                                                        id="<?php echo $book['bookId']; ?>">
                                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm deleteButton"
                                                        id="<?php echo $book['bookId']; ?>">
                                                        <i class="fa-regular fa-trash-can"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Modal for adding new book -->
                        <div class="modal fade" id="addBook" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Book</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addBookForm" method="POST" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                                <label style="width: 160px;" class="input-group-text"
                                                    for="bookCategoryInput">Book Category</label>
                                                <input type="text" class="form-control" id="bookCategoryInput"
                                                    name="bookCategory" placeholder="Enter Book Category" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Title</span>
                                                <input type="text" name="Title" class="form-control" required
                                                    placeholder="Enter Book Title" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Author</span>
                                                <input type="text" name="Author" class="form-control" required
                                                    placeholder="Enter Book Author" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Shelves
                                                    Number</span>
                                                <select name="columnNumber" class="form-select" required>
                                                    <option selected disabled>Choose Shelf Number...</option>
                                                    <option value="1">Shelf 1</option>
                                                    <option value="2">Shelf 2</option>
                                                    <option value="3">Shelf 3</option>
                                                    <option value="4">Shelf 4</option>
                                                    <option value="5">Shelf 5</option>
                                                    <option value="6">Shelf 6</option>
                                                    <option value="7">Shelf 7</option>
                                                    <option value="8">Shelf 8</option>
                                                    <option value="9">Shelf 9</option>
                                                    <option value="10">Shelf 10</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Accession</span>
                                                <input type="text" name="Accession" class="form-control" required
                                                    placeholder="Enter Book Accession" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Edition</span>
                                                <input type="number" name="bookEdition" class="form-control" required
                                                    placeholder="Enter Edition" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">Year</span>
                                                <input type="number" id="year" min="1900" step="1" name="bookYear"
                                                    class="form-control" placeholder="Enter Year" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px; align-text: center;"
                                                    class="input-group-text">Property</span>
                                                <input type="text" name="Property" class="form-control" required
                                                    placeholder="Enter Property" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px; align-text: center;"
                                                    class="input-group-text">Call Number</span>
                                                <input type="text" name="CallNumber" class="form-control" required
                                                    placeholder="Enter Call Number" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text">ISBN/ISSN</span>
                                                <input type="text" name="isbn" class="form-control" required
                                                    placeholder="Enter ISBN" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile01">Image Book
                                                    Stem</label>
                                                <input type="file" class="form-control" id="inputGroupFile01"
                                                    name="image1" accept="image/*" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile02">Image Front
                                                    Cover</label>
                                                <input type="file" class="form-control" id="inputGroupFile02"
                                                    name="image2" accept="image/*" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="addBookBtn">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ALERT -->
                        <div class="modal fade" id="alert" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Alert!</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="editBookId">
                        <!-- Add an edit modal -->
                        <div class="modal fade" id="editBookModal" tabindex="-1" role="dialog"
                            aria-labelledby="editBookModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBookModalLabel">Edit Book Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editBookForm">
                                            <input type="hidden" id="editBookId">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="bookCategoryEdit">Category</label>
                                                <input type="text" class="form-control" id="bookCategoryEdit" name="bookCategory" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="TitleEdit">Title</span>
                                                <input type="text" class="form-control" id="TitleEdit" name="Title"
                                                    required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="AuthorEdit">Author</span>
                                                <input type="text" class="form-control" id="AuthorEdit" name="Author"
                                                    required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="columnNumberEdit">Shelves Number</span>
                                                <select class="form-select" id="columnNumberEdit" name="columnNumber"
                                                    required>
                                                    <option selected disabled>Choose Shelf Number...</option>
                                                    <option value="1">Shelf 1</option>
                                                    <option value="2">Shelf 2</option>
                                                    <option value="3">Shelf 3</option>
                                                    <option value="4">Shelf 4</option>
                                                    <option value="5">Shelf 5</option>
                                                    <option value="6">Shelf 6</option>
                                                    <option value="7">Shelf 7</option>
                                                    <option value="8">Shelf 8</option>
                                                    <option value="9">Shelf 9</option>
                                                    <option value="10">Shelf 10</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="AccessionEdit">Accession</span>
                                                <input type="text" class="form-control" id="AccessionEdit"
                                                    name="Accession" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="bookEditionEdit">Book
                                                    Edition</span>
                                                <input type="number" class="form-control" id="bookEditionEdit"
                                                    name="bookEdition" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="bookYearEdit">Year</span>
                                                <input type="number" min="1900" step="1" class="form-control"
                                                    placeholder="Enter Year" class="form-control" id="bookYearEdit"
                                                    name="bookYear" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="PropertyEdit">Property</span>
                                                <input type="text" class="form-control" id="PropertyEdit"
                                                    name="Property" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span style=" width: 160px;" class="input-group-text"
                                                    for="callNumberEdit">Call
                                                    Number</span>
                                                <input type="text" class="form-control" id="callNumberEdit"
                                                    name="CallNumber" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Current Book Stem:</label>
                                                <img id="bookStemPreview" src="" alt="Book Stem" style="width: 100px; height: 100px;">
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="bookStemEdit">Upload New Book Stem</label>
                                                <input type="file" class="form-control" id="bookStemEdit" name="image1" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label>Current Front Cover:</label>
                                                <img id="frontCoverPreview" src="" alt="Front Cover" style="width: 100px; height: 100px;">
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="frontCoverEdit">Upload New Front Cover</label>
                                                <input type="file" class="form-control" id="frontCoverEdit" name="image2" accept="image/*">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveEditBookBtn">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            // Function to display alert
            function showAlert(message, type) {
                // Create an alert element
                var alertElement = $('<div>')
                    .addClass('alert alert-' + type)
                    .text(message);

                // Show the alert
                $('#alert .alert').replaceWith(alertElement);
                $('#alert').modal('show');

                // Automatically hide the alert after 3 seconds
                setTimeout(function () {
                    $('#alert').modal('hide');
                }, 3000);
            }

            // ADD NEW BOOK
            $('#addBookBtn').on('click', function () {
                // Ask for confirmation before adding the new book
                var confirmAdd = confirm("Are you sure you want to add this book?");
                if (!confirmAdd) {
                    return; // If the user does not confirm, stop form submission
                }

                // Reference to the form element
                var addBookForm = document.getElementById('addBookForm');

                // Check the form's validity using the HTML5 checkValidity method
                if (!addBookForm.checkValidity()) {
                    // Form is not valid; trigger built-in error display
                    addBookForm.reportValidity();
                    return; // Stop execution to prevent the form from being submitted
                }

                // Prevent duplicate form submissions by disabling the button while the request is ongoing
                $(this).prop('disabled', true);

                // Collect form data using FormData
                var formData = new FormData(addBookForm);

                // Make an AJAX request to add a new book
                $.ajax({
                    url: '/admin/classes/Book.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var data = JSON.parse(response);

                        if (data.type === 'success') {
                            // Close the modal and show success alert
                            $('#addBook').modal('hide');
                            showAlert('Book successfully added', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            // Show error alert
                            showAlert('Failed to add book: ' + data.message, 'danger');
                        }

                        // Re-enable the button
                        $('#addBookBtn').prop('disabled', false);
                    },
                    error: function () {
                        // Handle request error
                        showAlert('An error occurred while adding the book.', 'danger');
                        $('#addBookBtn').prop('disabled', false);
                    }
                });
            });

            // Edit button click event
            $('.editButton').on('click', function () {
                var bookId = $(this).attr('id'); // Get the book ID
                $('#editBookId').val(bookId); // Set the book ID in the hidden input field

                // Fetch book details by ID
                $.post('/admin/classes/Book.php', { getBookById: bookId }, function (data) {
                    var bookData = JSON.parse(data);
                    // Populate edit modal fields with fetched data
                    $('#bookCategoryEdit').val(bookData.bookCategory);
                    $('#TitleEdit').val(bookData.Title);
                    $('#AuthorEdit').val(bookData.Author);
                    $('#columnNumberEdit').val(bookData.columnNumber); // This will set the selected option based on bookData
                    $('#AccessionEdit').val(bookData.Accession);
                    $('#bookEditionEdit').val(bookData.bookEdition);
                    $('#bookYearEdit').val(bookData.bookYear);
                    $('#PropertyEdit').val(bookData.Property);
                    $('#callNumberEdit').val(bookData.callNumber);
                    $('#isbnEdit').val(bookData.isbn);


                    // Show the edit modal
                    $('#editBookModal').modal('show');
                });
            });

            // Save edit book button click event
            $('#saveEditBookBtn').on('click', function () {
                // Ask for confirmation before updating the book
                var confirmEdit = confirm("Are you sure you want to update this book?");
                if (!confirmEdit) {
                    return; // If the user does not confirm, stop form submission
                }

                // Collect form data, including files
                var form = document.getElementById('editBookForm');
                var formData = new FormData(form);

                // Add the book ID to the form data
                formData.append('bookId', $('#editBookId').val());

                // Make AJAX request to update the book details
                $.ajax({
                    url: '/admin/classes/Book.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.type === 'success') {
                            // Close the edit modal
                            $('#editBookModal').modal('hide');
                            showAlert('Book successfully updated', 'success');

                            // Reload the page to reflect the updated data
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert('Failed to update book: ' + data.message, 'danger');
                        }
                    },
                    error: function () {
                        showAlert('An error occurred while updating the book.', 'danger');
                    }
                });
            });

            // Deleting books
            $('.deleteButton').on('click', function (e) {
                var confirmDelete = confirm("Are you sure you want to delete this book?");
                if (confirmDelete) {
                    $.post('/admin/classes/Book.php', { deleteId: e.target.id }, function (data) {
                        var data = JSON.parse(data);
                        if (data.type === 'success') {
                            showAlert(data.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    });
                }
            });



            // Function for search
            $('#searchInput').on('input', function () {
                var searchType = $('#searchType').val(); // Get the selected search type (e.g. title, author, etc.)
                var searchText = $(this).val().toLowerCase();
                var rows = $('tbody tr');

                rows.each(function () {
                    var shouldShowRow = false; // Initially set shouldShowRow to false

                    // Check searchType and compare the appropriate column based on search type
                    if (searchType === 'title') {
                        var title = $(this).find('td:eq(4)').text().toLowerCase(); // Title is in the 5th column (index 4)
                        shouldShowRow = title.includes(searchText);
                    } else if (searchType === 'author') {
                        var author = $(this).find('td:eq(5)').text().toLowerCase(); // Author is in the 6th column (index 5)
                        shouldShowRow = author.includes(searchText);
                    } else if (searchType === 'year') {
                        var year = $(this).find('td:eq(9)').text().toLowerCase(); // Year is in the 10th column (index 9)
                        shouldShowRow = year.includes(searchText);
                    } else if (searchType === 'category') {
                        var category = $(this).find('td:eq(1)').text().toLowerCase(); // Category is in the 2nd column (index 1)
                        shouldShowRow = category.includes(searchText);
                    }

                    // Show or hide the row based on the value of shouldShowRow
                    if (shouldShowRow) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

        });

    </script>

    <script>
        $(document).ready(function () {
            const table = $('#datatablesSimple').DataTable({
                paging: true,
                responsive: true,
                searching: true,
                ordering: true,
                info: true,
                order: [[0, "desc"]]
            });

            // Delegate the click event to the table body
            $('#datatablesSimple tbody').on('click', '.editButton', function () {
                const bookId = $(this).attr('id');
                $('#editBookId').val(bookId);
                // Fetch and handle book edit functionality
                $.post('/admin/classes/Book.php', { getBookById: bookId }, function (data) {
                    const bookData = JSON.parse(data);
                    $('#bookCategoryEdit').val(bookData.bookCategory);
                    $('#TitleEdit').val(bookData.Title);
                    $('#AuthorEdit').val(bookData.Author);
                    $('#columnNumberEdit').val(bookData.columnNumber);
                    $('#AccessionEdit').val(bookData.Accession);
                    $('#bookEditionEdit').val(bookData.bookEdition);
                    $('#bookYearEdit').val(bookData.bookYear);
                    $('#PropertyEdit').val(bookData.Property);
                    $('#callNumberEdit').val(bookData.callNumber);
                    $('#isbnEdit').val(bookData.isbn);
                    $('#editBookModal').modal('show');
                });
            });

            $('#datatablesSimple tbody').on('click', '.deleteButton', function () {
                const confirmDelete = confirm("Are you sure you want to delete this book?");
                if (confirmDelete) {
                    const bookId = $(this).attr('id');
                    $.post('/admin/classes/Book.php', { deleteId: bookId }, function (data) {
                        const response = JSON.parse(data);
                        if (response.type === 'success') {
                            alert('Book deleted successfully');
                            table.row($(this).parents('tr')).remove().draw();
                        } else {
                            alert('Failed to delete the book.');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        const currentYear = new Date().getFullYear();

        const yearInput = document.getElementById('year');
        yearInput.setAttribute('max', currentYear);

        const bookYearInput = document.getElementById('bookYearEdit');
        bookYearInput.setAttribute('max', currentYear);
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
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

</body>

</html>
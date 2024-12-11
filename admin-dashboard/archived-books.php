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
    <!-- For High-Resolution Icons -->
    <link rel="icon" href="../assets/plvil-logo.svg" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #datatablesSimple_length {
            margin-bottom: 20px;
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

                        <!-- Featured -->
                        <a class="nav-link" href="featured-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                            Featured Items
                        </a>

                        <!-- Archive -->                         
                        <a class="nav-link" href="archived-books.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-archive"></i></div>
                            Archive
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
                    <h1 class="mt-4">Archived Books</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Archived Books</li>
                    </ol>


                    <!-- table -->
                    <div class="card mb-4 shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered display nowrap" id="datatablesSimple">
                                    <thead class="table-bordered table-light">
                                        <tr>
                                            <th class="text-center" width="5%">ID</th>
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
                                            <th class="text-center" width="10%">ISBN</th>
                                            <th class="text-center" width="10%">Archived At</th>
                                            <th class="text-center" width="5%">Restore Books</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $bookObj = new Book();
                                        $archivedBooks = $bookObj->getAllArchivedBooks();

                                        foreach ($archivedBooks as $book): ?>
                                            <tr>
                                                <td><?php echo $book['id']; ?></td>
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
                                                <td><?php echo $book['archivedAt']; ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm restoreButton"
                                                        id="<?php echo $book['id']; ?>">
                                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#datatablesSimple').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                order: [[0, "desc"]]
            });
        });

        // Restore book
        $('.restoreButton').on('click', function () {
            var confirmRestore = confirm("Are you sure you want to restore this book?");
            if (confirmRestore) {
                var archivedBookId = $(this).attr('id');
                $.post('/admin/classes/Book.php', { restoreId: archivedBookId }, function (response) {
                    var data = JSON.parse(response);
                    if (data.type === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        });

    </script>
</body>

</html>
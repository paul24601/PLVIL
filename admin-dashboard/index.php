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
if (isset($_GET['warning']) && $_GET['warning'] === 'restricted') {
    echo "<script>alert('Access Restricted: You do not have permission to access this page.');</script>";
}
?>

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

// SQL query to fetch data from the 'book' table
$sql = "SELECT bookId, Title, Author, bookYear, bookCategory FROM book";
$result = $conn->query($sql);

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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        
        #datatablesSimple_length {
            margin-bottom: 20px;
        }
    </style>
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
                        <a class="nav-link" href="featured-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                            Featured Items
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    
                    <!-- Charts -->
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Visitors Chart
                        </div>
                        <div class="card-body">
                            <!-- Dropdowns for Month and Year -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="filterMonth">Select Month:</label>
                                        <select id="filterMonth" class="form-select">
                                            <option value="">All</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="filterYear">Select Year:</label>
                                        <select id="filterYear" class="form-select">
                                            <option value="">All</option>
                                            <!-- Add options dynamically or hardcode based on your data range -->
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                            <canvas id="visitorsChart" width="100%" height="40"></canvas>
                        </div>
                    </div>


                    <!-- Tables -->
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Book List
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="display border table-light table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Published Year</th>
                                        <th>Genre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        // Output data for each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["bookId"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["Title"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["Author"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["bookYear"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["bookCategory"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No records found</td></tr>";
                                    }
                                    ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js" crossorigin="anonymous"></script>
    <script src="js/login.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        // Initial chart setup
        let visitorsChart;
        const ctx = document.getElementById('visitorsChart').getContext('2d');

        // Fetch and initialize chart with data
        fetch('../get-visitor-data.php')
            .then(response => response.json())
            .then(data => {
                initializeChart(data);
                applyFilters(data); // Call to apply filters initially or when the data is loaded
            })
            .catch(error => console.error('Error:', error));

        // Function to initialize the chart
        function initializeChart(data) {
            visitorsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'Number of Visitors',
                        data: data.counts,
                        borderColor: 'rgb(75, 192, 192)',
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Visitors'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Function to filter data
        function applyFilters(data) {
            const monthDropdown = document.getElementById('filterMonth');
            const yearDropdown = document.getElementById('filterYear');

            // Event listeners for dropdown changes
            monthDropdown.addEventListener('change', () => filterChartData(data));
            yearDropdown.addEventListener('change', () => filterChartData(data));
        }

        // Function to filter the chart data based on the selected month and year
        function filterChartData(data) {
            const selectedMonth = document.getElementById('filterMonth').value;
            const selectedYear = document.getElementById('filterYear').value;

            // Filter the original data based on selected month and year
            const filteredDates = [];
            const filteredCounts = [];
            data.dates.forEach((date, index) => {
                const [year, month] = date.split('-');
                if ((selectedMonth === '' || selectedMonth === month) && (selectedYear === '' || selectedYear === year)) {
                    filteredDates.push(date);
                    filteredCounts.push(data.counts[index]);
                }
            });

            // Update the chart with the filtered data
            visitorsChart.data.labels = filteredDates;
            visitorsChart.data.datasets[0].data = filteredCounts;
            visitorsChart.update();
        }

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

    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                responsive: true,
                pagingType: "full" // Optionally use 'simple' for simple pagination buttons
            });
        });
    </script>
    
    <script>
        // Fetch visitor data from the PHP script
        fetch('../get-visitor-data.php')
            .then(response => response.json())
            .then(data => {
                // Create the chart once the data is fetched
                var ctx = document.getElementById('visitorsChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.dates,  // X-axis (Dates)
                        datasets: [{
                            label: 'Number of Visitors',
                            data: data.counts,  // Y-axis (Counts)
                            borderColor: 'rgb(75, 192, 192)',
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Visitors'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    </script>

</body>

</html>
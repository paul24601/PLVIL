<?php
// Database connection details
$servername = "localhost"; // replace with your server name
$username = "root"; // replace with your MySQL username
$password = "Admin123@plvil"; // replace with your MySQL password
$dbname = "production_data"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recordCreated = false;

// Insert form data into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $machine = $_POST['machine'];
    $prn = $_POST['prn'];
    $product_name = $_POST['product_name'];
    $cycle_time_target = $_POST['cycle_time_target'];
    $cycle_time_actual = $_POST['cycle_time_actual'];
    $weight_standard = $_POST['weight_standard'];
    $weight_gross = $_POST['weight_gross'];
    $weight_net = $_POST['weight_net'];
    $cavity_designed = $_POST['cavity_designed'];
    $cavity_active = $_POST['cavity_active'];
    $remarks = $_POST['remarks'];
    $name = $_POST['name'];
    $shift = $_POST['shift'];
    $search = $_POST['search'];

    $sql = "INSERT INTO submissions (date, machine, prn, product_name, cycle_time_target, cycle_time_actual, weight_standard, weight_gross, weight_net, cavity_designed, cavity_active, remarks, name, shift, search) 
            VALUES ('$date', '$machine', '$prn', '$product_name', '$cycle_time_target', '$cycle_time_actual', '$weight_standard', '$weight_gross', '$weight_net', '$cavity_designed', '$cavity_active', '$remarks', '$name', '$shift', '$search')";

    if ($conn->query($sql) === TRUE) {
        $recordCreated = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from database
$sql = "SELECT * FROM submissions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Result</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .table-container {
            border: 1px solid #ddd; /* Border color */
            border-radius: .375rem; /* Rounded corners */
            padding: 1rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); /* Optional shadow */
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center">Form Submission Result</h2>

        <?php if ($recordCreated): ?>
            <!-- Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            New record created successfully.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="table-container m-3">
            <div class="table-responsive">
                <table id="submissionTable" class="table table-bordered table-striped pt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Machine</th>
                            <th>PRN</th>
                            <th>Product Name</th>
                            <th>Cycle Time (Target)</th>
                            <th>Cycle Time (Actual)</th>
                            <th>Weight (Standard)</th>
                            <th>Weight (Gross)</th>
                            <th>Weight (Net)</th>
                            <th>Cavity (Designed)</th>
                            <th>Cavity (Active)</th>
                            <th>Remarks</th>
                            <th>Name</th>
                            <th>Shift</th>
                            <th>Search</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["machine"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["prn"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["cycle_time_target"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["cycle_time_actual"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["weight_standard"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["weight_gross"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["weight_net"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["cavity_designed"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["cavity_active"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["shift"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["search"]) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='16' class='text-center'>No records found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="dms2.html" class="btn btn-primary">Back to Form</a>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#submissionTable').DataTable(); // Initialize DataTables
        });

        <?php if ($recordCreated): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        <?php endif; ?>
    </script>
</body>

</html>
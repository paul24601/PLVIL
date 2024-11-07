<?php
// Database connection
$servername = "localhost";
$username = "root";  // Adjust if needed
$password = "";      // Adjust if needed
$dbname = "admin_library";  // Your database

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch visit data (grouped by date)
$sql = "SELECT DATE(visit_time) as visit_date, COUNT(*) as visit_count FROM visitors GROUP BY DATE(visit_time)";
$result = $conn->query($sql);

$dates = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['visit_date'];
    $counts[] = $row['visit_count'];
}

$conn->close();

// Return data as JSON
echo json_encode(['dates' => $dates, 'counts' => $counts]);
?>

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

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

while (true) {
    // Fetch the current occupancy status
    $result = $conn->query("SELECT * FROM chair_occupancy");
    $occupancyData = [];

    while ($row = $result->fetch_assoc()) {
        $occupancyData[$row['chair_id']] = $row['status'];
    }

    // Send the data as JSON
    echo "data: " . json_encode($occupancyData) . "\n\n";
    flush();

    // Sleep for a short time before checking again
    sleep(2);
}
?>

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

// Get visitor IP and timestamp
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$visit_time = date('Y-m-d H:i:s');

// Insert visit data into the visitors table
$sql = "INSERT INTO visitors (ip_address, user_agent, visit_time) VALUES ('$ip_address', '$user_agent', '$visit_time')";

if ($conn->query($sql) === TRUE) {
    echo "Visit recorded!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

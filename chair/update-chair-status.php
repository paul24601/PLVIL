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

// Get the JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Ensure chair_id and status are set and valid
if (isset($data['chair_id']) && isset($data['status'])) {
    $chair_id = (int)$data['chair_id'];
    $status = (int)$data['status'];

    // Update the chair occupancy status in the database
    $sql = "UPDATE chair_occupancy SET status = ? WHERE chair_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $chair_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid data"]);
}

$conn->close();
?>

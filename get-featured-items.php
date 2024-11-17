<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = '$Admin123plvil';
$dbname = "admin_library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch featured items
$sql = "SELECT * FROM featured_items";
$result = $conn->query($sql);

$featuredItems = [];

while ($row = $result->fetch_assoc()) {
    $featuredItems[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'summary' => $row['summary'],
        'image_url' => $row['image_url'],
        'additional_info' => $row['additional_info'],
        'more_info_link' => $row['more_info_link']
    ];
}


echo json_encode($featuredItems);

$conn->close();
?>

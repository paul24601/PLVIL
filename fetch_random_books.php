<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "Admin123@plvil";
$dbname = "admin_library";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch random books (adjust LIMIT as needed)
$sql = "SELECT * FROM book ORDER BY RAND() LIMIT 3"; // Fetch 5 random books
$result = $conn->query($sql);

$randomBooks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $randomBooks[] = [
            'Title' => $row['Title'],
            'Author' => $row['Author'],
            'image2' => $row['image2'], // Ensure this field exists in your table
            'bookId' => $row['bookId'],
        ];
    }
}

echo json_encode($randomBooks);

$conn->close();
?>

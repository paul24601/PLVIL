<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/classes/DBConnection.php';

// Connect to the database
$db = new DBConnection();

// Retrieve the search term from the AJAX request
$search = isset($_GET['term']) ? $_GET['term'] : '';

// Query the database for matching categories
$query = $db->connect()->prepare("SELECT DISTINCT bookCategory FROM books WHERE bookCategory LIKE ? LIMIT 10");
$query->execute(["%$search%"]);

// Fetch the results and send them as a JSON response
$categories = $query->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($categories);
?>

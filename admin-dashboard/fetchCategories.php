<?php
include $_SERVER['DOCUMENT_ROOT'] . '/admin/classes/DBConnection.php';

$db = new DBConnection();
$search = isset($_GET['term']) ? $_GET['term'] : '';

$query = $db->connect()->prepare("SELECT DISTINCT category FROM categories WHERE category LIKE ? LIMIT 10");
$query->execute(["%$search%"]);

$categories = $query->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($categories);
?>

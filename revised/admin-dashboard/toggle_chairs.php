<?php
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
$id = $_GET['id'];
$query = $pdo->prepare("UPDATE chairs SET status = IF(status = 'available', 'occupied', 'available') WHERE id = ?");
$query->execute([$id]);
?>

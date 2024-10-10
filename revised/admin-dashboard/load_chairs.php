<?php
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
$query = $pdo->query("SELECT * FROM chairs");
$chairs = $query->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($chairs);
?>

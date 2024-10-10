<?php
$pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
$query = $pdo->prepare("INSERT INTO chairs (section, seat_number, status) VALUES ('tables-chairs', (SELECT COALESCE(MAX(seat_number), 0) + 1 FROM chairs WHERE section='tables-chairs'), 'available')");
$query->execute();
?>

<?php
$pdo = new PDO('mysql:host=localhost;dbname=admin_library', 'root', '');
$action = $_GET['action'];
$section = $_GET['section'] ?? null;

switch ($action) {
    case 'load':
        $query = $pdo->query("SELECT * FROM chairs");
        $chairs = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($chairs);
        break;

    case 'toggle':
        $id = $_GET['id'];
        $query = $pdo->prepare("UPDATE chairs SET status = IF(status = 'available', 'occupied', 'available') WHERE id = ?");
        $query->execute([$id]);
        break;

    case 'add':
        if ($section) {
            // Find the highest seat number in the specified section to ensure a unique seat number
            $query = $pdo->prepare("SELECT COALESCE(MAX(seat_number), 0) + 1 AS next_seat FROM chairs WHERE section = ?");
            $query->execute([$section]);
            $next_seat = $query->fetch(PDO::FETCH_ASSOC)['next_seat'];

            // Insert a new chair in the specified section with the new seat number
            $insert = $pdo->prepare("INSERT INTO chairs (section, seat_number, status) VALUES (?, ?, 'available')");
            $insert->execute([$section, $next_seat]);
        }
        break;

    case 'remove':
        if ($section) {
            // Remove the most recently added chair from the specified section
            $query = $pdo->prepare("DELETE FROM chairs WHERE id = (SELECT id FROM chairs WHERE section = ? ORDER BY seat_number DESC LIMIT 1)");
            $query->execute([$section]);
        }
        break;
}
?>

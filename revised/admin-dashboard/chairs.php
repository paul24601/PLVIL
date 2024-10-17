<?php
session_start();
if (!isset($_SESSION['userType'])) {
    header('Location: login.html');
    exit();
}
?>

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
        $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
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
            $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
        }
        break;

    case 'remove':
        if ($section) {
            // Remove the most recently added chair from the specified section
            $query = $pdo->prepare("DELETE FROM chairs WHERE id = (SELECT id FROM chairs WHERE section = ? ORDER BY seat_number DESC LIMIT 1)");
            $query->execute([$section]);
        }
        $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
        break;
        
        case 'check_changes':
            // Fetch the most recent update timestamp across all chairs
            $query = $pdo->query("SELECT MAX(last_updated) AS last_updated FROM chairs");
            $last_updated = $query->fetch(PDO::FETCH_ASSOC)['last_updated'];
            echo json_encode(['last_updated' => $last_updated]);
            break;
        
}
?>

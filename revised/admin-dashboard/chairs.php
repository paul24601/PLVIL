<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=admin_library', 'root', '');

$action = $_GET['action'];
$section = $_GET['section'] ?? null;

switch ($action) {
    case 'load':
        // This is the regular load process
        try {
            $query = $pdo->query("SELECT * FROM chairs");
            $chairs = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($chairs);
        } catch (Exception $e) {
            http_response_code(500);  // Internal Server Error
            echo json_encode(['error' => 'Failed to load chairs data', 'message' => $e->getMessage()]);
        }
        break;

    case 'manual_load':
        // Manual fallback in case the first load fails
        try {
            $query = $pdo->query("SELECT * FROM chairs");
            $chairs = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($chairs); // Directly fetching data from the database as fallback
        } catch (Exception $e) {
            http_response_code(500);  // Internal Server Error
            echo json_encode(['error' => 'Manual load failed', 'message' => $e->getMessage()]);
        }
        break;

    case 'toggle':
        $id = $_GET['id'];
        try {
            $query = $pdo->prepare("UPDATE chairs SET status = IF(status = 'available', 'occupied', 'available') WHERE id = ?");
            $query->execute([$id]);
            $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to toggle chair', 'message' => $e->getMessage()]);
        }
        break;

    case 'add':
        if ($section) {
            try {
                $query = $pdo->prepare("SELECT COALESCE(MAX(seat_number), 0) + 1 AS next_seat FROM chairs WHERE section = ?");
                $query->execute([$section]);
                $next_seat = $query->fetch(PDO::FETCH_ASSOC)['next_seat'];
                $insert = $pdo->prepare("INSERT INTO chairs (section, seat_number, status) VALUES (?, ?, 'available')");
                $insert->execute([$section, $next_seat]);
                $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add chair', 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'remove':
        if ($section) {
            try {
                $query = $pdo->prepare("DELETE FROM chairs WHERE id = (SELECT id FROM chairs WHERE section = ? ORDER BY seat_number DESC LIMIT 1)");
                $query->execute([$section]);
                $pdo->query("UPDATE change_tracker SET last_updated = NOW() WHERE id = 1");
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to remove chair', 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'check_changes':
        try {
            // Check if the query succeeds
            $query = $pdo->query("SELECT last_updated FROM change_tracker WHERE id = 1");
            
            // Fetch the result
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            // Debugging: Output raw result for debugging purposes
            if (!$result) {
                throw new Exception("No result returned from query.");
            }
    
            // Ensure last_updated exists in the result
            if (!isset($result['last_updated'])) {
                throw new Exception("last_updated not found in the result.");
            }
    
            // Return the last_updated value
            $last_updated = $result['last_updated'];
            echo json_encode(['last_updated' => $last_updated]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch last updated timestamp', 'message' => $e->getMessage()]);
        }
        break;
        
}

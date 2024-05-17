<?php

class SeatUpdater {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "library_seat_viewer";
    private $conn;

    // Constructor to establish database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to update seat occupancy
    public function updateSeatOccupancy($seatId, $seatType, $occupied) {
        $stmt = $this->conn->prepare("UPDATE seats SET occupied = ? WHERE seatId = ? AND seatType = ?");
        $stmt->bind_param("iis", $occupied, $seatId, $seatType); // Corrected "s" for seatType
        if ($stmt->execute()) {
            $stmt->close();
            return "success";
        } else {
            // Log SQL error
            error_log("SQL Error: " . $stmt->error);
            $stmt->close();
            return "error";
        }
    }

    // Destructor to close database connection
    public function __destruct() {
        $this->conn->close();
    }
}

// Create an instance of the class
$seatUpdater = new SeatUpdater();

// Decode JSON data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is valid
if (isset($data['seatId'], $data['seatType'], $data['occupied'])) {
    $seatId = $data['seatId'];
    $seatType = $data['seatType'];
    $occupied = $data['occupied'] ? 1 : 0;

    // Call the method to update seat occupancy
    echo $seatUpdater->updateSeatOccupancy($seatId, $seatType, $occupied);
} else {
    echo "error"; // Data is incomplete
}

?>

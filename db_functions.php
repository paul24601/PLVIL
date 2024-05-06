<?php

class db_functions {
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "admin_seatview";

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
        
         if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function updateSeatOccupancy($seatId, $occupied) {
        $stmt = $this->conn->prepare("UPDATE seat_occupancy SET occupied = ? WHERE seat_id = ?");
        $stmt->bind_param("ii", $occupied, $seatId);
        $stmt->execute();
        $stmt->close();
    }
}
?>

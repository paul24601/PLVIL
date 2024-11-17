<?php

class DBseatInitialize {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "library_seat_viewer";
    private $conn; // Variable to hold the database connection
    
    // Constructor to establish the database connection
    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to initialize seats in the database
    public function initializeSeats() {
        // Insert tables and chairs (160 seats)
        for ($i = 0; $i < 160; $i++) {
            $sql = "INSERT INTO seats (seatType, occupied) VALUES ('tables_chairs', FALSE)";
            $this->conn->query($sql);
        }

        // Insert computer seats (9 seats)
        for ($i = 0; $i < 9; $i++) {
            $sql = "INSERT INTO seats (seatType, occupied) VALUES ('computer', FALSE)";
            $this->conn->query($sql);
        }

        // Insert graduate study seats (30 seats)
        for ($i = 0; $i < 30; $i++) {
            $sql = "INSERT INTO seats (seatType, occupied) VALUES ('graduate', FALSE)";
            $this->conn->query($sql);
        }
    }

    // Destructor to close the database connection
    public function __destruct() {
        $this->conn->close();
    }
}

// Create an instance of the class and initialize seats
$dbSeatInitialize = new DBseatInitialize();
$dbSeatInitialize->initializeSeats();

?>

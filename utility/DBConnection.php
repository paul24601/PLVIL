<?php
    class DBConnection{
        private $server ="localhost";
        private $username = "root";
        private $password = "";
        private $db = "admin_library";

        public $conn;

        public function __construct(){
            try{
                $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);

                if($this->conn->connect_error){
                    throw new Exception("Error ocurred:  ". $this->connect_error);
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
?>
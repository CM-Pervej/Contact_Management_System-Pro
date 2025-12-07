<?php
    namespace App\Config;

    class Database {
        private $host = 'localhost';
        private $db_name = 'contact_manager';
        private $username = 'root';
        private $password = 'root';
        private $conn;

        // Connect to database 
        // Use construct because we don't need to call a construct function as it is automatically response
        public function __construct() {
            $this->conn = new \mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db_name
            );

            if($this->conn->connect_error){
                // die("Connection failed: " . $this->conn->connect_error);
                throw new \Exception("Database connection failed: " . $this->conn->connect_error);
            } 
            else {
                // echo "Database Connection Successful";
            }

            // Set charset (VERY IMPORTANT for UTF-8/Bangla)
            $this->conn->set_charset("utf8mb4");
        }

        public function getConnection() {
            return $this->conn;
        }
    }

    // $database = new Database;
?>
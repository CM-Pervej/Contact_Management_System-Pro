<?php
    namespace App\Core;
    use App\Config\Database;

    class Model {
        protected $conn;    // Connection should be protected so that only the child models can use it only.

        public function __construct() {
            $database = new Database;   // Create a Database object
            $this->conn = $database->getConnection();   // Save the mysqli connection in this model
        }

        // Clean user input (Avoid sql injection)
        protected function clean($value) {
            return $this->conn->real_escape_string(trim($value));
        }

        // Run SELECT queries and return mysqli result
        protected function selectQuery($query) {
            $result = $this->conn->query($query);

            if(!$result){
                throw new \Exception("Query Failed: " . $this->conn->error);
            }

            return $result;
        }

        // Run INSERT, UPDATE, DELETE queries
        protected function executeQuery($query) {
            if(!$this->conn->query($query)){
                throw new \Exception("Query Failed: " . $this->conn->error);
            }

            return true;
        }

        protected function lastInsertedId() {
            return $this->conn->insert_id;
        }
    }
?>
<?php
    namespace App\Core;
    use App\Config\Database;

    class Model {
        protected $conn;    // Connection should be protected so that only the child models can use it.

        public function __construct() { // this construct function and the Database construct functions are not same.
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

            return $result; // this will return values to render, that's why $result
        }

        // Run INSERT, UPDATE, DELETE queries
        protected function executeQuery($query) {
            if(!$this->conn->query($query)){
                throw new \Exception("Query Failed: " . $this->conn->error);
            }

            return true;  // this needs to not return anything, that's why boolean (yes)
        }

        protected function lastInsertedId() {
            return $this->conn->insert_id;  //  insert_id is a built-in property of mysqli
        }
    }
?>
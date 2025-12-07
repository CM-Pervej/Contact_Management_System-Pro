<?php
    namespace App\Models;
    use App\Core\Model;

    class User extends Model {
        private $table = 'users';

        // Register users 
        public function register($name, $email, $password) {
            // clean input for avoiding SQL injection
            $name = $this->clean($name);
            $email = $this->clean($email);
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // query variable as Insert into database query
            $query = "INSERT INTO {$this->table} (name, email, password) VALUES ('$name', '$email', '$passwordHash')";

            // executeQuery() with query variable
            $this->executeQuery($query);

            // Return last inserted id 
            return $this->lastInsertedId();
        }

        public function getByEmail($email) {
            $email = $this->clean($email);
            $query = "SELECT * FROM {$this->table} WHERE email = '$email' LIMIT 1";
            $result = $this->selectQuery($query);
            return $result->fetch_assoc();
        }
    }
?>
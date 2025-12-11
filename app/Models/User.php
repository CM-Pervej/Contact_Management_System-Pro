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

        // Check if email exist
        public function getByEmail($email) {
            $email = $this->clean($email);
            $query = "SELECT * FROM {$this->table} WHERE email = '$email' LIMIT 1";
            $result = $this->selectQuery($query);
            return $result->fetch_assoc();
        }

        // login 
        public function login($email, $password){
            $email = $this->clean($email);
            $query = "SELECT * FROM {$this->table} WHERE email = '$email' LIMIT 1";
            $result = $this->selectQuery($query);

            $user = $result->fetch_assoc();

            if(!$user){
                return false;  // email not found
            }

            if(password_verify($password, $user['password'])){
                return $user;
            }

            return false; // incorrect password
        }

        // Get user id (for edit form)
        public function getById($id) {
            $id = (int) $id;
            $query = "SELECT * FROM {$this->table} WHERE id = $id LIMIT 1";
            $result = $this->selectQuery($query);
            return $result->fetch_assoc();
        }

        // update user details 
        public function update($id, $name, $email) {
            $id = (int) $id;
            $name = $this->clean($name);
            $email= $this->clean($email);

            $query = "UPDATE {$this->table} SET name = '$name', email = '$email' WHERE id = '$id'";

            return $this->executeQuery($query);
        }
    }
?>
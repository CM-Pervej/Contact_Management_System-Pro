<?php
    namespace App\Controllers;
    use App\Models\User;

    class AuthController {
        public $errors = [];
        public $success = '';

        // registration 
        public function register() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $confirm = trim($_POST['confirm_password']);

                if(empty($name) || empty($email) || empty($password)){
                    $this->errors[] = "All fields are required!";
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $this->errors[] = "Invalid email format";
                } else if($password !== $confirm) {
                    $this->errors[] = "Password and Confirm password does not matched";
                } else {
                    $user = new User;
    
                    try{
                        $existing = $user->getByEmail($email);
    
                        if($existing){
                            $this->errors[] = "Email already exist / registered";
                        } else {
                            $userId = $user->register($name, $email, $password);
                            $this->success = "Registration successful! Your id: $userId";
                        }
                    } catch(\Exception $e){
                        $this->errors[] = $e->getMessage();
                    }
                }
            }
        }

        // login 
        public function login() {
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
    
                if(empty($email) || empty($password)){
                    $this->errors[] = "Both fields are required";
                } else {
                    $user = new User;
                    $loggedInUser = $user->login($email, $password);
    
                    if($loggedInUser) {
                        // start session and store user info 
                        $_SESSION['user'] = [
                            'id' => $loggedInUser['id'],
                            'name' => $loggedInUser['name'],
                            'email' => $loggedInUser['email']
                        ];
    
                        // redirect to dashboard
                        header("Location: dashboard.php");
                        exit;
                    } else {
                        $this->errors[] = "Invalid email or password";
                    }
                }
            }
        }
    }
?>
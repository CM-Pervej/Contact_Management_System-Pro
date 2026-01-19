<?php 
    namespace App\Controllers;
    use App\Models\User;

    class UserController {
        public $errors = [];
        public $success = '';

        public function editForm($id) {
            $user = new User;
            return $user->getById($id);
        }

        public function update($id) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = (int) $id;
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);

                if(empty($name) || empty($email)) {
                    $this->errors[] = "All fields are required!";
                    return false;
                } else {
                    $user = new User;
        
                    $existing = $user->getByEmail($email);
                    if($existing && $existing['id'] != $id) {
                        $this->errors[] = "Email already in use!";
                        return false;
                    }
        
                    try{
                        $user->update($id, $name, $email);
        
                        session_start();
                        $_SESSION['user']['name'] = $name;
                        $_SESSION['user']['email'] = $email;
        
                        $this->success = "Profile updated successfully!";
                        return true;
                    } catch(\Exception $e){
                        $this->errors[] = $e->getMessage();
                        return false;
                    }
                }
            }
        }
    }
?>
<?php
namespace App\Controllers;

use App\Models\User;

class UserController
{
    public $errors = [];
    public $success = "";

    // Load user for edit form
    public function editForm($id)
    {
        $user = new User();
        return $user->getById($id);
    }

    // Update user info
public function update($id, $name, $email)
{
    $user = new User();

    if (empty($name) || empty($email)) {
        $this->errors[] = "All fields are required!";
        return false;
    }

    // Prevent duplicate email
    $existing = $user->getByEmail($email);
    if ($existing && $existing['id'] != $id) {
        $this->errors[] = "Email already in use!";
        return false;
    }

    try {
        // 1. Update DB
        $user->update($id, $name, $email);

        // 2. Fetch updated user data
        session_start();

        // 3. Update session properly
        $_SESSION['user']['name']  = $name;
        $_SESSION['user']['email'] = $email;

        $this->success = "Profile updated successfully!";
        return true;

    } catch (\Exception $e) {
        $this->errors[] = $e->getMessage();
        return false;
    }
}

}
?>

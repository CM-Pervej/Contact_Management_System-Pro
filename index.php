<?php
    require_once __DIR__ . '/vendor/autoload.php';
    use App\Models\User;

    try {
        $user = new User();
        $newUserId = $user->register("John Doe", "john@example.com", "123456");
        echo "New user created with ID: $newUserId";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
?>
<?php
    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Controllers\AuthController;

    $auth = new AuthController();
    $auth->login();

    $errors = $auth->errors;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach ($errors as $error) echo $error . "<br>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p><a href="register.php">Don't have an account? Register</a></p>

</body>
</html>

<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use App\Controllers\AuthController;

    session_start();

    $auth = new AuthController;
    $auth->register();

    $errors = $auth->errors;
    $success = $auth->success;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach($errors as $error) echo $error . "<br>"; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <p><a href="login.php">Already have an account? Login here</a></p>
</body>
</html>
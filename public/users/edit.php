<?php
    require_once "../../vendor/autoload.php";

    use App\Controllers\UserController;

    $controller = new UserController();

    // Edit page needs ?id=1
    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("User ID missing!");
    }

    // Load existing user
    $user = $controller->editForm($id);

    // If update form submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $updated = $controller->update(
            $id,
            $_POST['name'],
            $_POST['email']
        );

        if ($updated) {
            $message = $controller->success;
        } else {
            $errors = $controller->errors;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<?php if (!empty($errors)): ?>
    <div style="color:red">
        <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
    </div>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <div style="color:green"><?= $message ?></div>
<?php endif; ?>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $user['name'] ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user['email'] ?>"><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>

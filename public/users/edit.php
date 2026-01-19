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

    //update
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $controller->update($id);
    }

    $message = $controller->success;
    $errors = $controller->errors;

    $pageTitle = "CMS-Pro / Edit User";
    require_once '../layout/layout.php';
?>

<section class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit User</h2>

    <!-- Errors -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error mb-4">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-success mb-4"><?= $message ?></div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Name</label>
            <input type="text" name="name" id="name"value="<?= htmlspecialchars($user['name']) ?>" class="input input-bordered w-full" required >
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
            <input type="email" name="email" id="email"value="<?= htmlspecialchars($user['email']) ?>" class="input input-bordered w-full" required >
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="btn btn-primary w-full">Update</button>
        </div>
    </form>
</section>

<?php require_once '../layout/footer.php'; ?>
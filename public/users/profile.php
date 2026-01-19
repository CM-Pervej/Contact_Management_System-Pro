<?php
    session_start();
    $pageTitle = "CMS-Pro/" . htmlspecialchars($_SESSION['user']['name']);
    require_once '../layout/layout.php';
?>

<section class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center space-x-4">
        <div class="avatar">
            <div class="w-24 rounded-full">
                <img src="https://i.pravatar.cc/150?u=<?= htmlspecialchars($user['id']) ?>" alt="User Avatar" />
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold"><?= htmlspecialchars($user['name']) ?></h2>
            <p class="text-gray-500"><?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>

    <div class="mt-6 space-y-2">
        <a href="/contact/public/users/edit.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-primary w-full">Edit Profile</a>
        <a href="/contact/public/logout.php" class="btn btn-secondary w-full">Logout</a>
    </div>
</section>

<?php require_once '../layout/footer.php'; ?>
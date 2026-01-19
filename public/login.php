<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use App\Controllers\AuthController;

    session_start();

    $auth = new AuthController;
    $auth->login();

    $errors = $auth->errors;
?>

<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="/contact/uploads/logo.png" type="image/png">
  <title>Sign In | ContactMS Pro</title>

  <!-- Tailwind + DaisyUI -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-base-200">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- LEFT: BRAND -->
        <div class="hidden lg:flex flex-col justify-center px-20 bg-base-100 border-r border-base-300">
            <h1 class="text-4xl font-bold mb-6"> ContactMS <span class="text-primary"> Pro </span> </h1>
            <p class="text-lg text-base-content/70 mb-8 max-w-md"> Sign in to manage your contacts with confidence and security. </p>
            <ul class="space-y-4 text-base-content/70">
                <li>✔ Secure authentication</li>
                <li>✔ Fast dashboard access</li>
                <li>✔ Built for professionals</li>
                <li>✔ Trusted by teams</li>
            </ul>
        </div>

        <!-- RIGHT: LOGIN FORM -->
        <div class="flex items-center justify-center px-6">
            <div class="w-full max-w-md bg-base-100 shadow-xl rounded-lg">
                <!-- Header -->
                <div class="p-8 border-b border-base-300 text-center">
                    <h2 class="text-2xl font-semibold">Sign in</h2>
                    <p class="text-sm text-base-content/60 mt-2"> Welcome back 👋 </p>

                    <?php if (!empty($errors)): ?>
                        <div class="mt-4 text-red-600 text-sm">
                            <?php foreach ($errors as $error): ?>
                            <?= $error ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Form -->
                <form method="POST" action="" class="px-8 py-6 space-y-4">
                    <div>
                        <label class="label"> <span class="label-text font-medium">Email Address</span> </label>
                        <input type="email" name="email" class="input input-bordered w-full" placeholder="Enter your email" required>
                    </div>
                    <div>
                        <label class="label"> <span class="label-text font-medium"> Password </span> </label>
                        <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
                    </div>
                    <button class="btn btn-primary w-full"> Sign In </button>
                </form>

                <!-- Footer -->
                <div class="p-6 border-t border-base-300 text-center text-sm text-base-content/60">
                    Don’t have an account?
                    <a href="register.php" class="link link-primary font-medium"> Create one </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

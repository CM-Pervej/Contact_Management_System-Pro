<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use App\Controllers\AuthController;

    session_start();

    $auth = new AuthController;
    $auth->register();

    $errors = $auth->errors;
    $success = $auth->success;
?>
<!--
    How the data is going to controller, right?
    Actually the controller is using $_POST super global as PHP gives direct access of $_POST to the controller
-->

<!DOCTYPE html>
<html lang="en" data-theme="corporate">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="/contact/uploads/logo.png" type="image/png">
        <title>Create Account | ContactMS Pro</title>

        <!-- Tailwind + DaisyUI -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-base-200">
        <div class="min-h-screen grid lg:grid-cols-2">
            <!-- LEFT: BRAND / INFO -->
            <div class="hidden lg:flex flex-col justify-center px-20 bg-base-100 border-r border-base-300">
                <h1 class="text-4xl font-bold mb-6"> ContactMS <span class="text-primary"> Pro </span> </h1>

                <p class="text-lg text-base-content/70 mb-8 max-w-md"> Create your account and start managing contacts with clarity, security, and enterprise-level reliability.</p>

                <ul class="space-y-4 text-base-content/70">
                    <li>✔ Centralized contact management</li>
                    <li>✔ Role-based access control</li>
                    <li>✔ Secure cloud infrastructure</li>
                    <li>✔ Built for growing teams</li>
                </ul>
            </div>

            <!-- RIGHT: REGISTER FORM -->
            <div class="flex items-center justify-center px-6">
                <div class="w-full max-w-md bg-base-100 shadow-xl rounded-lg">
                    <!-- Header -->
                    <div class="p-8 border-b border-base-300 text-center">
                        <h2 class="text-2xl font-semibold">Create your account</h2>
                        <p class="text-sm text-base-content/60 mt-2"> It takes less than a minute </p>
                        <div>
                            <?php if(!empty($errors)): ?>
                                <p class="text-red-600">
                                <?php foreach($errors as $error) echo $error . "<br>"; ?>
                                </p>
                            <?php endif; ?>
                            <?php if($success): ?>
                                <p class="text-green-600">
                                <?= $success ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Form -->
                    <form class="px-8 py-3 space-y-3" method="POST" action="">

                        <div>
                            <label class="label"> <span class="label-text font-medium">Full Name</span> </label>
                            <input type="text" name="name" class="input input-bordered w-full" placeholder="Enter your name" required>
                        </div>

                        <div>
                            <label class="label"> <span class="label-text font-medium">Email Address</span> </label>
                            <input type="email" name="email" class="input input-bordered w-full" placeholder="Enter your email" required>
                        </div>

                        <div>
                            <label class="label"> <span class="label-text font-medium">Password</span> </label>
                            <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
                        </div>

                        <div>
                            <label class="label"> <span class="label-text font-medium">Confirm Password</span> </label>
                            <input type="password" name="confirm_password" class="input input-bordered w-full" placeholder="••••••••" required>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary mr-2" required>
                            <label class="text-sm text-gray-600">I agree to the <a href="#" class="text-indigo-600 underline">terms & conditions</a></label>
                        </div>

                        <button class="btn btn-primary w-full"> Create Account </button>
                    </form>

                    <!-- Footer -->
                    <div class="p-6 border-t border-base-300 text-center text-sm text-base-content/60">
                        Already have an account?
                        <a href="login.php" class="link link-primary font-medium"> Sign in </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
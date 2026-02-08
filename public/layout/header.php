<?php
    // this condition is to use session with multiple session_start()
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header("Location: /contact/public/login.php");
        exit;
    }

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/contact/uploads/logo.png" type="image/png">
  <title><?php echo isset($pageTitle) ? $pageTitle : "Contact Management System - Pro"; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

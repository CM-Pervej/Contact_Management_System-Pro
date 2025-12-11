<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    $user = $_SESSION['user'];

    require_once "./layout/layout.php";
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($pageTitle) ? $pageTitle : "Contact Management System - Pro"; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-base-200 flex flex-col min-h-screen">

<?php
    session_start();
    session_destroy();
    header("Location: /contact/public/login.php");
    exit;
?>
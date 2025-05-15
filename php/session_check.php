<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nëse përdoruesi nuk është i kyçur, ktheje tek login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

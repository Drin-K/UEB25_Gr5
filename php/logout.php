<?php
session_start();

// Fshi të gjitha të dhënat e session
$_SESSION = array();

// Fshi cookie-in e session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Fshi cookie-t e remember me
setcookie('remember_user', '', time() - 3600, '/');
setcookie('remember_email', '', time() - 3600, '/');

// Shkatërro session
session_destroy();

// Ridrejto në faqen e login
header("Location: login.php");
exit();
?>
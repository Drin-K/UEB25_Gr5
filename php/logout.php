<?php
session_start();
session_unset();
session_destroy();

setcookie('remember_user', '', time() - 3600, '/');
setcookie('remember_email', '', time() - 3600, '/');

header("Location: login.php");
exit();
?>

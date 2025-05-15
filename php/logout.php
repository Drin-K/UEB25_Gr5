<?php
session_start();

// Fshij të gjitha të dhënat e sesionit
$_SESSION = [];

// Shkatërro sesionin
session_destroy();

// Ridrejto tek faqja e login
header("Location: login.php");
exit();

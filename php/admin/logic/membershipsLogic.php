<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

include("../db.php");

function handleDbError($msg, $stmt = null) {
    if ($stmt) {
        throw new Exception($msg . " " . $stmt->error);
    } else {
        throw new Exception($msg);
    }
}

$addMessage = "";
$editMessage = "";
$deleteMessage = "";
$memberships = $conn->query("SELECT * FROM memberships");
?>
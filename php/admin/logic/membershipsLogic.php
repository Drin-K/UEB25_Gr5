<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

require_once("../db.php");
require_once("../general/error_handler.php");
trigger_error("Ky është një test nga membershipsLogic.php!", E_USER_WARNING);
function handleDbError($msg, $stmt = null) {
    $details = $stmt ? $stmt->error : '';
    trigger_error($msg . ' ' . $details, E_USER_WARNING);
}

$addMessage = "";
$editMessage = "";
$deleteMessage = "";
$memberships = $conn->query("SELECT * FROM memberships");
?>
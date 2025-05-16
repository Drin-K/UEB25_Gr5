<?php
session_start();
require_once "db.php";

header('Content-Type: application/json');
ini_set('display_errors', 0);  // Mos shfaq gabime në output
ini_set('log_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['user_id'];

$sql_active = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
               FROM subscriptions s
               JOIN memberships m ON s.membership_id = m.id
               WHERE s.user_id = ? AND s.status = 'active'
               ORDER BY s.end_date DESC
               LIMIT 1";

$stmt = $conn->prepare($sql_active);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$active_membership = $result->fetch_assoc();
$stmt->close();

if ($active_membership) {
    echo json_encode($active_membership);
} else {
    echo json_encode(null);
}
?>

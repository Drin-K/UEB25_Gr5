<?php
session_start();
require_once '../db.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

$sql_active = "SELECT m.name, m.price, p.payment_date, p.status
               FROM payments p
               JOIN memberships m ON p.id_membership = m.id
               WHERE p.user_id = ? AND p.status = 'active'
               ORDER BY p.payment_date DESC
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

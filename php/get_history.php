<?php
session_start();
require_once "db.php";

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

$sql = "SELECT m.name, m.price, p.payment_date, p.status
        FROM payments p
        JOIN memberships m ON p.id_membership = m.id
        WHERE p.user_id = ?
        ORDER BY p.payment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$history = [];

while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

echo json_encode($history);
?>

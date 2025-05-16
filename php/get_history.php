<?php
session_start();
require_once "db.php";

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

$sql = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
        FROM subscriptions s
        JOIN memberships m ON s.membership_id = m.id
        WHERE s.user_id = ?
        ORDER BY s.start_date DESC";

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

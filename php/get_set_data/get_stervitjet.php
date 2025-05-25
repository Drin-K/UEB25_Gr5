<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? 0;

$successMessage = $_SESSION['success_message'] ?? "";
unset($_SESSION['success_message']);

$suggestedPlanId = null;
$activePlanId = $_SESSION['active_plan_id'] ?? null;


$stmt = $conn->prepare("SELECT id FROM workout_plans WHERE user_id = ? ORDER BY usage_count DESC LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $suggestedPlan = $result->fetch_assoc();
    $suggestedPlanId = $suggestedPlan['id'];
}
$stmt->close();


$lastUsedPlanId = $_COOKIE['last_used_plan'] ?? null;


$stmt = $conn->prepare("SELECT * FROM workout_plans WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$plans = $stmt->get_result();
?>
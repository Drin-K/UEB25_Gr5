<?php
require_once "../db.php";

// o Kthimi përmes referencës
function &getReports(mysqli &$conn): array {
    global $conn;
    $reports = [];

    $query = "
        SELECT 
        u.id AS user_id,
        u.name,
        u.email,
        u.created_at,
        (SELECT COUNT(*) FROM workout_plans wp WHERE wp.user_id = u.id) AS total_workouts,
        (SELECT COUNT(*) FROM payments p WHERE p.user_id = u.id) AS total_payments,
        (SELECT IFNULL(SUM(m.price), 0) 
        FROM payments p 
        JOIN memberships m ON m.id = p.id_membership 
        WHERE p.user_id = u.id) AS total_paid,
        (SELECT GROUP_CONCAT(DISTINCT np.category SEPARATOR ', ') 
        FROM user_nutrition_preferences unp 
        JOIN nutrition_plans np ON np.category IS NOT NULL 
        WHERE unp.user_id = u.id) AS nutrition_categories,
        (SELECT preferred_calories 
        FROM user_nutrition_preferences 
        WHERE user_id = u.id 
        LIMIT 1) AS preferred_calories,
        (SELECT m.name 
        FROM payments p 
        JOIN memberships m ON m.id = p.id_membership 
        WHERE p.user_id = u.id 
        ORDER BY p.payment_date DESC LIMIT 1) AS membership
        FROM users u
        WHERE u.role = 'client'
    ";

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }

    return $reports;
}

function getCalorieDistribution(mysqli $conn): array {
    $query = "
        SELECT 
            np.category,
            AVG(np.calories) AS avg_calories,
            COUNT(*) AS plan_count
        FROM nutrition_plans np
        GROUP BY np.category
    ";
    
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

$allReports = &getReports($conn);
$calorieData = getCalorieDistribution($conn);
unset($conn);
?>

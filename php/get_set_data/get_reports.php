<?php
require_once "../db.php";

function &getReports(mysqli &$conn): array {
    $reports = [];

    $query = "
    SELECT 
        u.id AS user_id,
        u.name,
        u.email,
        u.created_at,
        (
            SELECT COUNT(*) 
            FROM workout_plans wp 
            WHERE wp.user_id = u.id
        ) AS total_workouts,
        (
            SELECT COUNT(*) 
            FROM payments p 
            WHERE p.user_id = u.id
        ) AS total_payments,
        (
            SELECT m.name 
            FROM payments p 
            JOIN memberships m ON m.id = p.id_membership 
            WHERE p.user_id = u.id 
            ORDER BY p.payment_date DESC 
            LIMIT 1
        ) AS last_membership,
        (
            SELECT preferred_calories 
            FROM user_nutrition_preferences unp 
            WHERE unp.user_id = u.id
        ) AS preferred_calories
    FROM users u
    WHERE u.role = 'client'
    ";

    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
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
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return $data;
}

$allReports = &getReports($conn);
$calorieData = getCalorieDistribution($conn);

$conn->close();
?>

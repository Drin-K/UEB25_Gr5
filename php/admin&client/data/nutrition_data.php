<?php
include '../db.php';
session_start();

// Verifikimi i përdoruesit
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Trajtimi i POST kërkesave
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_plan']) && $_SESSION['role'] === 'admin') {
        $stmt = $conn->prepare("INSERT INTO nutrition_plans (title, description, calories, protein, carbs, fats, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiis", $_POST['title'], $_POST['description'], $_POST['calories'], $_POST['protein'], $_POST['carbs'], $_POST['fats'], $_POST['category']);
        $stmt->execute();
    } elseif (isset($_POST['save_preferences'])) {
        $stmt = $conn->prepare("REPLACE INTO user_nutrition_preferences (user_id, preferred_calories, dietary_restrictions, favorite_meals) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $_SESSION['user_id'], $_POST['preferred_calories'], $_POST['dietary_restrictions'], $_POST['favorite_meals']);
        $stmt->execute();
    } elseif (isset($_POST['delete_plan']) && $_SESSION['role'] === 'admin') {
        $stmt = $conn->prepare("DELETE FROM nutrition_plans WHERE id = ?");
        $stmt->bind_param("i", $_POST['plan_id']);
        $stmt->execute();
    }
}

// Marrja e preferencave dhe planeve
$preferences = ['preferred_calories' => '', 'dietary_restrictions' => '', 'favorite_meals' => ''];
$plansResult = null;

if ($_SESSION['role'] === 'client') {
    $stmt = $conn->prepare("SELECT preferred_calories, dietary_restrictions, favorite_meals FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $preferences = $row;
    }

    $minCalories = (int)$preferences['preferred_calories'] - 200;
    $maxCalories = (int)$preferences['preferred_calories'] + 200;

    $query = "SELECT * FROM nutrition_plans WHERE calories BETWEEN ? AND ?";
    $params = [$minCalories, $maxCalories];
    $types = "ii";

    if (!empty($preferences['dietary_restrictions'])) {
        $restrictions = explode(',', $preferences['dietary_restrictions']);
        foreach ($restrictions as $restriction) {
            $restriction = trim($restriction);
            if ($restriction !== '') {
                $query .= " AND description NOT LIKE ?";
                $params[] = '%' . $restriction . '%';
                $types .= "s";
            }
        }
    }

    if (!empty($preferences['favorite_meals'])) {
        $favoriteMeals = explode(',', $preferences['favorite_meals']);
        $favoriteMealsConditions = [];
        foreach ($favoriteMeals as $meal) {
            $meal = trim($meal);
            if ($meal !== '') {
                $favoriteMealsConditions[] = "(title LIKE ? OR description LIKE ?)";
                $params[] = '%' . $meal . '%';
                $params[] = '%' . $meal . '%';
                $types .= "ss";
            }
        }
        if (count($favoriteMealsConditions) > 0) {
            $query .= " AND (" . implode(" OR ", $favoriteMealsConditions) . ")";
        }
    }

    $planStmt = $conn->prepare($query);
    $planStmt->bind_param($types, ...$params);
    $planStmt->execute();
    $plansResult = $planStmt->get_result();
} else {
    $plansResult = $conn->query("SELECT * FROM nutrition_plans");
}

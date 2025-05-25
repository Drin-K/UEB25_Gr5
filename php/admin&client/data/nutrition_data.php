<?php
require_once '../db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

$preferences = ['preferred_calories' => 0, 'dietary_restrictions' => '', 'favorite_meals' => ''];

if ($_SESSION['role'] === 'client') {
    $stmt = $conn->prepare("SELECT preferred_calories, dietary_restrictions, favorite_meals FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $preferences = $row;
    }

    $minCalories = max(0, (int)$preferences['preferred_calories'] - 200);
    $maxCalories = (int)$preferences['preferred_calories'] + 200;

    $query = "SELECT * FROM nutrition_plans WHERE calories BETWEEN ? AND ?";
    $params = [$minCalories, $maxCalories];
    $types = "ii";

    if ($preferences['dietary_restrictions'] !== '') {
        foreach (explode(',', $preferences['dietary_restrictions']) as $r) {
            $r = trim($r);
            if ($r !== '') {
                $query .= " AND description NOT LIKE ?";
                $params[] = "%$r%";
                $types .= "s";
            }
        }
    }
    if ($preferences['favorite_meals'] !== '') {
        $likes = [];
        foreach (explode(',', $preferences['favorite_meals']) as $m) {
            $m = trim($m);
            if ($m !== '') {
                $likes[] = "(title LIKE ? OR description LIKE ?)";
                $params[] = "%$m%";
                $params[] = "%$m%";
                $types .= "ss";
            }
        }
        if ($likes) {
            $query .= " AND (" . implode(" OR ", $likes) . ")";
        }
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $plansResult = $stmt->get_result();

} else {
    $plansResult = $conn->query("SELECT * FROM nutrition_plans");
}
if (isset($_POST['show_all_plans'])) {
    $plansQuery = "SELECT * FROM nutrition_plans";
    $plansResult = $conn->query($plansQuery);
}
?>


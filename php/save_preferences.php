<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$userId = (int)$_SESSION['user_id'];

// Ruaj kaloritë e preferuara
if (isset($_POST['calories'])) {
    $calories = max(1000, min((int)$_POST['calories'], 8000)); // kufizo kaloritë logjikisht

    $stmt = $conn->prepare("SELECT user_id FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $exists = $stmt->get_result()->num_rows > 0;

    if ($exists) {
        $update = $conn->prepare("UPDATE user_nutrition_preferences SET preferred_calories = ? WHERE user_id = ?");
        $update->bind_param("ii", $calories, $userId);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO user_nutrition_preferences (user_id, preferred_calories) VALUES (?, ?)");
        $insert->bind_param("ii", $userId, $calories);
        $insert->execute();
    }

    setcookie('nutrition_calories', $calories, time() + 86400 * 30, "/");
    $_SESSION['success_message'] = "Preferencat u ruajtën me sukses!";
}

// Ruaj ngjyrën e background
if (isset($_POST['bg_color'])) {
    $color = htmlspecialchars($_POST['bg_color']);
    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        setcookie('bg_preference', $color, time() + 86400 * 30, "/");
        $_SESSION['visual_updated'] = true;
    }
}

// Fshi cookies nëse kërkohet
if (isset($_POST['reset_cookies'])) {
    foreach (['nutrition_calories', 'viewed_plans', 'bg_preference'] as $cookie) {
        setcookie($cookie, '', time() - 3600, "/");
    }
    $_SESSION['success_message'] = "Cookies u fshinë me sukses!";
}

header("Location: nutrition.php");
exit();

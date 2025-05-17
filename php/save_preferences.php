<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Ruajtja e preferencave bazë
if (isset($_POST['calories'])) {
    $calories = (int)$_POST['calories'];
    
    // Kontrollo nëse përdoruesi ka preferenca të regjistruara më parë
    $stmt = $conn->prepare("SELECT user_id FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $exists = $stmt->get_result()->num_rows > 0;

    if ($exists) {
        $query = "UPDATE user_nutrition_preferences SET preferred_calories = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $calories, $userId);
    } else {
        $query = "INSERT INTO user_nutrition_preferences (preferred_calories, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $calories, $userId);
    }

    if ($stmt->execute()) {
        setcookie('nutrition_calories', $calories, time() + 86400 * 30, "/");
        $_SESSION['success_message'] = "Preferencat u ruajtën me sukses!";
    } else {
        $_SESSION['error_message'] = "Gabim në ruajtjen e preferencave: " . $conn->error;
    }
    $stmt->close();
}

// Ruajtja e preferencave vizuale
if (isset($_POST['bg_color'])) {
    $bgColor = $_POST['bg_color'];
    setcookie('bg_preference', $bgColor, time() + 86400 * 30, "/");
    $_SESSION['visual_updated'] = true;
}

// Fshirja e cookies
if (isset($_POST['reset_cookies'])) {
    setcookie('nutrition_calories', '', time() - 3600, "/");
    setcookie('viewed_plans', '', time() - 3600, "/");
    setcookie('bg_preference', '', time() - 3600, "/");
    $_SESSION['success_message'] = "Cookies u fshinë me sukses!";
}

header("Location: nutrition.php");
exit();
?>
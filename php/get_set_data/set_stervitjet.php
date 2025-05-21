<?php
session_start();
require_once "../db.php";

$userId = $_SESSION['user_id'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_plan'])) {
        $planId = $_POST['plan_id'];
        $newDescription = $_POST['description'];
        $newTitle = $_POST['title'];

        $stmt = $conn->prepare("UPDATE workout_plans SET description = ?, title = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $newDescription, $newTitle, $planId, $userId);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "✅ Plani u përditësua me sukses!";
        } else {
            $_SESSION['success_message'] = "❌ Ndodhi një gabim gjatë përditësimit!";
        }
        $stmt->close();
    }
    elseif (isset($_POST['create_plan'])) {
        $title = $_POST['new_title'];
        $description = $_POST['new_description'];

        if (!empty($title)) {
            $stmt = $conn->prepare("INSERT INTO workout_plans (user_id, title, description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $title, $description);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "✅ Plani i ri u krijua me sukses!";
            } else {
                $_SESSION['success_message'] = "❌ Ndodhi një gabim gjatë krijimit të planit!";
            }
            $stmt->close();
        } else {
            $_SESSION['success_message'] = "❌ Titulli nuk mund të jetë bosh!";
        }
    }
    elseif (isset($_POST['delete_plan'])) {
        $planId = $_POST['plan_id'];

        $stmt = $conn->prepare("DELETE FROM workout_plans WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $planId, $userId);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "✅ Plani u fshi me sukses!";
        } else {
            $_SESSION['success_message'] = "❌ Ndodhi një gabim gjatë fshirjes së planit!";
        }
        $stmt->close();
    }
    elseif (isset($_POST['select_plan'])) {
        $planId = $_POST['plan_id'];

        // Update usage count
        $stmt = $conn->prepare("UPDATE workout_plans SET usage_count = usage_count + 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $planId, $userId);
        $stmt->execute();
        $stmt->close();

        // Set session and cookie
        $_SESSION['active_plan_id'] = $planId;
        setcookie('last_used_plan', $planId, time() + (30 * 24 * 60 * 60), "/");

        $_SESSION['success_message'] = "✅ Plani u zgjodh si aktiv!";
    }
}

header("Location: ../stervitjet.php");
exit();
?>
<?php
// profile_logic.php
include("../db.php");
session_start();

// Kontroll nëse është loguar
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// FUNKSIONET
function getUserData($userId, $conn) {
    $stmt = $conn->prepare("SELECT Name, Email, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUserData($userId, $name, $email, $conn) {
    $stmt = $conn->prepare("UPDATE users SET Name = ?, Email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $userId);
    return $stmt->execute();
}

function changePassword($userId, $currentPass, $newPass, $conn) {
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!password_verify($currentPass, $user['password'])) {
        return "Current password is incorrect";
    }

    $newHash = password_hash($newPass, PASSWORD_DEFAULT);
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newHash, $userId);

    return $updateStmt->execute() ? true : $conn->error;
}

// Marrim të dhënat aktuale të përdoruesit
$userData = getUserData($_SESSION['user_id'], $conn);

// Përpunimi i formës së profilit
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (updateUserData($_SESSION['user_id'], $name, $email, $conn)) {
        $successMessage = "Profili u përditësua me sukses!";
        $userData = getUserData($_SESSION['user_id'], $conn); // rifresko të dhënat
    } else {
        $successMessage = "Gabim në përditësim: " . $conn->error;
    }
}

// Përpunimi i ndryshimit të fjalëkalimit
$passwordMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'])) {
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    if ($newPass !== $confirmPass) {
        $passwordMessage = "Fjalëkalimet e reja nuk përputhen.";
    } elseif (strlen($newPass) < 8) {
        $passwordMessage = "Fjalëkalimi duhet të ketë të paktën 8 karaktere.";
    } else {
        $result = changePassword($_SESSION['user_id'], $currentPass, $newPass, $conn);
        $passwordMessage = $result === true ? "Fjalëkalimi u ndryshua me sukses!" : "Gabim: " . $result;
    }
}

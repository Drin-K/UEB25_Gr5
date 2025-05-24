<?php
include("../db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

function getUserData($id, $conn) {
    $stmt = $conn->prepare("SELECT Name, Email, created_at FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUserData($id, $name, $email, $conn) {
    $stmt = $conn->prepare("UPDATE users SET Name=?, Email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
    return $stmt->execute();
}

function changePassword($id, $curr, $new, $conn) {
    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!password_verify($curr, $user['password'])) return "Fjalëkalimi aktual është gabim";

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $stmt2 = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt2->bind_param("si", $hash, $id);
    return $stmt2->execute() ? true : $conn->error;
}

$userData = getUserData($_SESSION['user_id'], $conn);

$successMessage = '';
$passwordMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'])) {
        if (updateUserData($_SESSION['user_id'], $_POST['name'], $_POST['email'], $conn)) {
            $successMessage = "Profili u përditësua me sukses!";
            $userData = getUserData($_SESSION['user_id'], $conn);
        } else {
            $successMessage = "Gabim në përditësim: " . $conn->error;
        }
    } elseif (isset($_POST['current_password'])) {
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $passwordMessage = "Fjalëkalimet e reja nuk përputhen.";
        } elseif (strlen($_POST['new_password']) < 8) {
            $passwordMessage = "Fjalëkalimi duhet të ketë të paktën 8 karaktere.";
        } else {
            $res = changePassword($_SESSION['user_id'], $_POST['current_password'], $_POST['new_password'], $conn);
            $passwordMessage = $res === true ? "Fjalëkalimi u ndryshua me sukses!" : "Gabim: " . $res;
        }
    }
}

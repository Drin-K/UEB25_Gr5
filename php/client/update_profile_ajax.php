<?php
session_start();
include("../db.php");

function updateUserData($id, $name, $email, $conn) {
    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
    return $stmt->execute();
}

if (!isset($_SESSION['user_id'])) {
    echo "Sesioni ka skaduar. Ju lutem kyçuni përsëri.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        echo "Emri dhe emaili janë të detyrueshme.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Emaili nuk është në formatin e duhur.";
        exit;
    }

    $id = $_SESSION['user_id'];
    if (updateUserData($id, $name, $email, $conn)) {
        echo "Profili u përditësua me sukses!";
    } else {
        echo "Gabim gjatë përditësimit të të dhënave. Ju lutem provoni përsëri.";
    }
}
?>

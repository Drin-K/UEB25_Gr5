<?php
require_once "../db.php";

if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
        header("Location: ../admin/manage_users.php?add=✅ Përdoruesi u shtua me sukses!");
    } else {
        header("Location: ../admin/manage_users.php?add=❌ Emaili ekziston ose ndodhi një gabim!");
    }
    exit;
}

if (isset($_POST['delete_user_id'])) {
    $userId = $_POST['delete_user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        header("Location: ../admin/manage_users.php?delete=✅ Përdoruesi u fshi me sukses!");
    } else {
        header("Location: ../admin/manage_users.php?delete=❌ Ndodhi një gabim gjatë fshirjes!");
    }
    exit;
}
?>
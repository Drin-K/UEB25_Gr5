<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../db.php");

function respondJson($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}

if (isset($_POST['ajax_edit'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0 && is_numeric($id)) {
        $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
        if (!$stmt || !$stmt->bind_param("sdi", $name, $price, $id) || !$stmt->execute()) {
            respondJson(false, "Gabim gjatë përditësimit: " . $stmt->error);
        }
        $stmt->close();
        respondJson(true, "Përditësuar me sukses.");
    } else {
        respondJson(false, "Të dhënat janë të pavlefshme.");
    }
}


if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
        if (!$stmt || !$stmt->bind_param("sd", $name, $price) || !$stmt->execute()) {
            $msg = "Gabim gjatë shtimit të membership-it.";
            header("Location: ../admin/manage_memberships.php?addMessage=" . urlencode($msg));
            exit();
        }
        $stmt->close();
    } else {
        header("Location: ../admin/manage_memberships.php?addMessage=" . urlencode("Emri ose çmimi nuk janë të vlefshëm."));
        exit();
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
        if (!$stmt || !$stmt->bind_param("i", $id) || !$stmt->execute()) {
            $msg = "Gabim gjatë fshirjes.";
            header("Location: ../admin/manage_memberships.php?deleteMessage=" . urlencode($msg));
            exit();
        }
        $stmt->close();
    }
    header("Location: ../admin/manage_memberships.php");
    exit();
}

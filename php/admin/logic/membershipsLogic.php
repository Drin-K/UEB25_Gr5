<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../db.php");

function handleDbError($msg, $stmt = null) {
    if ($stmt) {
        throw new Exception($msg . " " . $stmt->error);
    } else {
        throw new Exception($msg);
    }
}

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        try {
            $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për insert.");
            $stmt->bind_param("sd", $name, $price);
            if (!$stmt->execute()) handleDbError("Gabim gjatë shtimit të membership-it.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $addMessage = $e->getMessage();
        }
    } else {
        $addMessage = "Emri ose çmimi nuk janë të vlefshëm.";
    }
}

if (isset($_POST['edit_inline'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        try {
            $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për update.");
            $stmt->bind_param("sdi", $name, $price, $id);
            if (!$stmt->execute()) handleDbError("Gabim gjatë përditësimit.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $editMessage = $e->getMessage();
        }
    } else {
        $editMessage = "Të dhënat për përditësim janë të pavlefshme.";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (is_numeric($id)) {
        try {
            $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për fshirje.");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) handleDbError("Gabim gjatë fshirjes.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $deleteMessage = $e->getMessage();
        }
    }
}

$memberships = $conn->query("SELECT * FROM memberships");

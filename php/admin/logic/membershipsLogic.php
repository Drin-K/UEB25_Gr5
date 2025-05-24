<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once("../db.php");
require_once("../general/error_handler.php");
trigger_error("Ky është një test nga membershipsLogic.php!", E_USER_WARNING);
function handleDbError($msg, $stmt = null) {
    $details = $stmt ? $stmt->error : '';
    trigger_error($msg . ' ' . $details, E_USER_WARNING);
}

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
        if (!$stmt) {
            $addMessage = "Gabim gjatë përgatitjes për insert.";
            handleDbError($addMessage);
        } else {
            $stmt->bind_param("sd", $name, $price);
            if (!$stmt->execute()) {
                $addMessage = "Gabim gjatë shtimit të membership-it.";
                handleDbError($addMessage, $stmt);
            }
            $stmt->close();
        }
    } else {
        $addMessage = "Emri ose çmimi nuk janë të vlefshëm.";
        trigger_error($addMessage, E_USER_WARNING);
    }
}

if (isset($_POST['edit_inline'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
        if (!$stmt) {
            $editMessage = "Gabim gjatë përgatitjes për update.";
            handleDbError($editMessage);
        } else {
            $stmt->bind_param("sdi", $name, $price, $id);
            if (!$stmt->execute()) {
                $editMessage = "Gabim gjatë përditësimit.";
                handleDbError($editMessage, $stmt);
            }
            $stmt->close();
        }
    } else {
        $editMessage = "Të dhënat për përditësim janë të pavlefshme.";
        trigger_error($editMessage, E_USER_WARNING);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
        if (!$stmt) {
            $deleteMessage = "Gabim gjatë përgatitjes për fshirje.";
            handleDbError($deleteMessage);
        } else {
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                $deleteMessage = "Gabim gjatë fshirjes.";
                handleDbError($deleteMessage, $stmt);
            }
            $stmt->close();
        }
    }
}

$memberships = $conn->query("SELECT * FROM memberships");
?>
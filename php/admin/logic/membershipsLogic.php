<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

include(__DIR__ . "/../../db.php");
require_once(__DIR__ . "/../../general/error_handler.php");

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

function respondJson($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit();
}

function handleDbError($msg, $stmt = null) {
    $details = $stmt ? $stmt->error : '';
    trigger_error($msg . ' ' . $details, E_USER_WARNING);
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
        if (!$stmt) {
            $addMessage = "Gabim gjatë përgatitjes për insert.";
            handleDbError($addMessage);
        } else {
            $stmt->bind_param("sd", $name, $price);
            if (!$stmt->execute()) {
                $addMessage = "Gabim gjatë shtimit të membership-it.";
                handleDbError($addMessage, $stmt);
            } else {
                header("Location: ../manage_memberships.php");
                exit();
            }
            $stmt->close();
        }
    } else {
        $addMessage = "Emri ose çmimi nuk janë të vlefshëm.";
        trigger_error($addMessage, E_USER_WARNING);
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
            } else {
                header("Location: ../manage_memberships.php");
                exit();
            }
            $stmt->close();
        }
    }
}

$memberships = $conn->query("SELECT * FROM memberships");
?>
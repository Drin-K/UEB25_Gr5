<?php


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
    try {
        $name = trim($_POST['name']);
        $price = $_POST['price'];

        if (empty($name) || !is_numeric($price) || $price <= 0) {
            throw new Exception("Emri ose çmimi nuk janë të vlefshëm.");
        }

        $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Gabim gjatë përgatitjes për insert.");
        }

        if (!$stmt->bind_param("sd", $name, $price)) {
            throw new Exception("Gabim gjatë lidhjes së parametrave.");
        }

        if (!$stmt->execute()) {
            throw new Exception("Gabim gjatë shtimit të membership-it: " . $stmt->error);
        }

        $stmt->close();
        header("Location: ../manage_memberships.php");
        exit();
    } catch (Exception $e) {
        $addMessage = $e->getMessage();
        trigger_error($addMessage, E_USER_WARNING);
    }
}


if (isset($_GET['delete'])) {
    try {
        $id = $_GET['delete'];
        if (!is_numeric($id)) {
            throw new Exception("ID e pavlefshme për fshirje.");
        }

        $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
        if (!$stmt) {
            throw new Exception("Gabim gjatë përgatitjes për fshirje.");
        }

        if (!$stmt->bind_param("i", $id)) {
            throw new Exception("Gabim gjatë lidhjes së parametrave.");
        }

        if (!$stmt->execute()) {
            throw new Exception("Gabim gjatë fshirjes: " . $stmt->error);
        }

        $stmt->close();
        header("Location: ../manage_memberships.php");
        exit();
    } catch (Exception $e) {
        $deleteMessage = $e->getMessage();
        trigger_error($deleteMessage, E_USER_WARNING);
    }
}

$memberships = $conn->query("SELECT * FROM memberships");
?>
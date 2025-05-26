<?php



require_once(__DIR__ . "/../../db.php");
require_once(__DIR__ . "/../../general/error_handler.php");

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

function handleDbError($msg, $stmt = null) {
    $details = $stmt ? $stmt->error : '';
    trigger_error($msg . ' ' . $details, E_USER_WARNING);
}

if (isset($_POST['ajax_edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    if ($name && $price > 0 && $id > 0) {
        $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
        if ($stmt && $stmt->bind_param("sdi", $name, $price, $id) && $stmt->execute()) {
            $stmt->close();
            echo "Përditësuar me sukses.";
        } else {
            echo "Gabim gjatë përditësimit.";
        }
    } else {
        echo "Të dhënat janë të pavlefshme.";
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
            handleDbError("Gabim gjatë përgatitjes për insert.", $stmt);
            return;
        }

        if (!$stmt->bind_param("sd", $name, $price)) {
            handleDbError("Gabim gjatë lidhjes së parametrave.", $stmt);
            return;
        }

        if (!$stmt->execute()) {
            handleDbError("Gabim gjatë shtimit të membership-it", $stmt);
            return;
        }

        $stmt->close();
        header("Location: ../manage_memberships.php");
        exit();
    } catch (Exception $e) {
        $addMessage = $e->getMessage();
        handleDbError($addMessage);
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
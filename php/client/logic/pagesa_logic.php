<?php
require_once("../db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}


if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    $_SESSION['visit_count']++;
}
$GLOBALS['visitMessage'] = "Ju keni vizituar këtë faqe " . $_SESSION['visit_count'] . " herë në këtë sesion.";


$memberships = [];
$query = $conn->query("SELECT id, name, price FROM memberships");
while ($row = $query->fetch_assoc()) {
    $memberships[] = $row;
}
$GLOBALS['memberships'] = $memberships;

$successMessage = "";
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bankNumber = $_POST['bank_number'];
    $id_membership = $_POST['id_membership'];
    $paymentDate = date('Y-m-d');
    $method = 'Online';

    $stmt = $conn->prepare("INSERT INTO payments (user_id, numri_bankes, payment_date, method, id_membership) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("isssi", $userId, $bankNumber, $paymentDate, $method, $id_membership);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "✅ Pagesa për membership u regjistrua me sukses!";
        } else {
            $_SESSION['success_message'] = "❌ Dështoi ekzekutimi i query-t.";
        }
        $stmt->close();
    } else {
        $_SESSION['success_message'] = "❌ Gabim gjatë përgatitjes së query-t.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
$GLOBALS['successMessage'] = $successMessage;

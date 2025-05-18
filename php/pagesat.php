<?php

include("header.php");
include("sidebar.php");
include("db.php");

$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? null;

$successMessage = "";
$sessionTotal = null;
$sessionDate = null;

// ✅ Nëse forma është dërguar
if ($_SERVER["REQUEST_METHOD"] == "POST" && $userId !== null) {
    $amount = $_POST['amount'];
    $method = 'Online';
    $bankNumber = $_POST['bank_number'];
    $paymentDate = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, bank_number, payment_date, method) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("idsss", $userId, $amount, $bankNumber, $paymentDate, $method);
        if ($stmt->execute()) {
            // ✅ Ruaj në sesion për një herë
            $_SESSION['success_message'] = "✅ Pagesa me kartelë u regjistrua me sukses!";
            $_SESSION['total_paid'] = ($_SESSION['total_paid'] ?? 0) + $amount;
            $_SESSION['last_payment_date'] = $paymentDate;

            // ✅ Redirect në vetveten për të shmangur riPOST nga refresh
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $_SESSION['success_message'] = "❌ Dështoi ekzekutimi i query-t.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['success_message'] = "❌ Gabim gjatë përgatitjes së query-t.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ✅ Pas redirect – shfaq mesazhet dhe pastro sesionin
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['total_paid'])) {
    $sessionTotal = $_SESSION['total_paid'];
    unset($_SESSION['total_paid']);
}

if (isset($_SESSION['last_payment_date'])) {
    $sessionDate = $_SESSION['last_payment_date'];
    unset($_SESSION['last_payment_date']);
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Pagesa - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/pagesat.css">
</head>
<body>
    <div class="content">
        <h2>Pagesa</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert-success">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($sessionTotal) && !empty($sessionDate)): ?>
            <div class="session-info">
                <p><strong>Totali i pagesave në këtë sesion:</strong> €<?= number_format($sessionTotal, 2) ?></p>
                <p><strong>Data e fundit e pagesës:</strong> <?= htmlspecialchars($sessionDate) ?></p>
            </div>
        <?php endif; ?>

        <p class="payment-instructions">
            Ju lutemi shkruani shumën dhe numrin e kartelës për pagesë. Nëse preferoni të paguani me cash, ju lutemi na vizitoni në zyrën tonë.
        </p>

        <form method="post" class="payment-form">
            <div class="form-group">
                <label for="amount">Shuma (€):</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0.01" required placeholder="Shkruani shumën">
            </div>

            <div class="form-group">
                <label for="bank_number">Numri i Kartelës:</label>
                <input type="text" id="bank_number" name="bank_number" maxlength="16" pattern="\d{16}" required
                       placeholder="1234 5678 9012 3456">
            </div>

            <button type="submit" class="btn-paguaj">PAGUAJ</button>
        </form>
    </div>
</body>
</html>

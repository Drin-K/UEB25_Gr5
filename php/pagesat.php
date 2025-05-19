<?php
include("header.php");
include("sidebar.php");
include("db.php");

if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    $_SESSION['visit_count']++;
}
$visitMessage = "Ju keni vizituar këtë faqe " . $_SESSION['visit_count'] . " herë në këtë sesion.";

$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? null;

$successMessage = "";

$memberships = [];
$query = $conn->query("SELECT id, name, price FROM memberships");
while ($row = $query->fetch_assoc()) {
    $memberships[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $userId !== null) {
    $bankNumber = $_POST['bank_number'];
    $id_membership = $_POST['id_membership'];
    $paymentDate = date('Y-m-d');
    $method = 'Online';

    $stmt = $conn->prepare("INSERT INTO payments (user_id, bank_number, payment_date, method, id_membership) VALUES (?, ?, ?, ?, ?)");
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
        <div class="alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <p class="payment-instructions">
        Ju lutemi zgjidhni një membership dhe shkruani numrin e kartelës për të përfunduar pagesën.
    </p>

    <form method="post" class="payment-form">
        <div class="form-group">
            <label for="id_membership">Zgjidh Membership-in:</label>
            <select id="id_membership" name="id_membership" required>
                <option value="">-- Zgjidh --</option>
                <?php foreach ($memberships as $membership): ?>
                    <option value="<?= $membership['id'] ?>">
                        <?= htmlspecialchars($membership['name']) ?> - €<?= number_format($membership['price'], 2) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="bank_number">Numri i Kartelës:</label>
            <input type="text" id="bank_number" name="bank_number" maxlength="16" pattern="\d{16}" required
                   placeholder="1234567812345678">
        </div>

        <button type="submit" class="btn-paguaj">PAGUAJ</button>

        <div class="visit-counter" style="padding-top: 130px;">
            <p><?= htmlspecialchars($visitMessage) ?></p>
        </div>
    </form>
</div>
</body>
</html>

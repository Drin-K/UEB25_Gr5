<?php
include("header.php");
include("sidebar.php");
include("db.php");
$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'];

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $method = 'Online';
    $bankNumber = $_POST['bank_number'];
    $paymentDate = date('Y-m-d');

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, bank_number, payment_date, method) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("idsss", $userId, $amount, $bankNumber, $paymentDate, $method);
        if ($stmt->execute()) {
            $successMessage = "✅ Pagesa me kartelë u regjistrua me sukses!";
        } else {
            $successMessage = "❌ Dështoi ekzekutimi i query-t.";
        }
        $stmt->close();
    } else {
        $successMessage = "❌ Gabim gjatë përgatitjes së query-t.";
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/pagesat.css">

</head>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagesa - ILLYRIAN GYM</title>
</head>
<body>
    <div class="content">
        <h2>Pagesa</h2>
        
        <?php if (!empty($successMessage)): ?>
            <div class="alert-success">
                <?= htmlspecialchars($successMessage) ?>
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
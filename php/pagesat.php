<?php
session_start(); // Ensure session is started if not already

include("header.php");
include("sidebar.php");
include("db.php");

// Assuming role is stored in session
$role = $_SESSION['role'] ?? 'guest';

$successMessage = "";

// DB connection
try {
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount = $_POST['amount'];
        $method = $_POST['method'];

        $stmt = $pdo->prepare("INSERT INTO payments (amount, method) VALUES (:amount, :method)");
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':method', $method);
        $stmt->execute();

        $successMessage = "✅ Payment recorded successfully!";
    }
} catch (PDOException $e) {
    $successMessage = "❌ Database error: " . $e->getMessage();
}
?>

<html>
<head>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
<div class="content">
    <h2>Pagesat</h2>
    <p>Koment najsen per pagesa</p>

    <?php if (!empty($successMessage)): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Shuma (Amount):</label><br>
        <input type="number" name="amount" step="0.01" required><br><br>

        <label>Mënyra e pagesës (Method):</label><br>
        <input type="text" name="method" required><br><br>

        <button type="submit">Paguaj</button>
    </form>
</div>

<?php include("footer.php"); ?>
</body>
</html>

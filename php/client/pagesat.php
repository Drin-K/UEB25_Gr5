<?php
include("../general/header.php");
include("../general/sidebar.php");
require_once("logic/pagesa_logic.php"); 

$successMessage = $GLOBALS['successMessage'] ?? '';
$visitMessage = $GLOBALS['visitMessage'] ?? '';
$memberships = $GLOBALS['memberships'] ?? [];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Pagesa - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/pagesat.css">
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

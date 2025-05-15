<?php
include("header.php");
include("sidebar.php");

$user_id = $_SESSION['user_id'];
require_once "db.php";

$sql_active = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
        FROM subscriptions s
        JOIN memberships m ON s.membership_id = m.id
        WHERE s.user_id = ? AND s.status = 'active'
        ORDER BY s.end_date DESC
        LIMIT 1";

$stmt = $conn->prepare($sql_active);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$active_membership = $result->fetch_assoc();
$stmt->close();

$sql_history = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
        FROM subscriptions s
        JOIN memberships m ON s.membership_id = m.id
        WHERE s.user_id = ?
        ORDER BY s.start_date DESC";

$stmt = $conn->prepare($sql_history);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_history = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anëtarësimi</title>
    <link rel="stylesheet" href="../css/anetaresimet.css">
</head>
<body>
    <div class="membership-container">
        <h2>Anëtarësimi aktual</h2>
        <?php if ($active_membership): ?>
            <div class="current-membership">
                <p><strong>Emri:</strong> <?= htmlspecialchars($active_membership['name']) ?></p>
                <p><strong>Çmimi:</strong> €<?= htmlspecialchars($active_membership['price']) ?></p>
                <p><strong>Fillon më:</strong> <?= htmlspecialchars($active_membership['start_date']) ?></p>
                <p><strong>Skadon më:</strong> <?= htmlspecialchars($active_membership['end_date']) ?></p>
                <p><strong>Statusi:</strong> <span class="status-active"><?= htmlspecialchars($active_membership['status']) ?></span></p>
            </div>
        <?php else: ?>
            <div class="current-membership">
                <p class="no-membership">Nuk keni asnjë anëtarësim aktiv.</p>
            </div>
        <?php endif; ?>

        <h2>Historiku i anëtarësimeve</h2>
        <table>
            <thead>
                <tr>
                    <th>Emri</th>
                    <th>Çmimi</th>
                    <th>Fillimi</th>
                    <th>Skadimi</th>
                    <th>Statusi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_history->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>€<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td class="status-<?= strtolower(htmlspecialchars($row['status'])) ?>">
                            <?= htmlspecialchars($row['status']) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
include("footer.php");
?>
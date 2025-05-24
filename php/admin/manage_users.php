<?php
include("../general/header.php");
include("../general/sidebar.php");
include("../get_set_data/get_users.php"); // Fetch users and handle messages  
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Menaxho Përdoruesit</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/users.css">
</head>
<body>
<div class="content">
    <h2>Menaxhimi i Përdoruesve</h2>

    <?php if ($addMessage): ?><div class="alert"><?= $addMessage ?></div><?php endif; ?>
    <?php if ($deleteMessage): ?><div class="alert"><?= $deleteMessage ?></div><?php endif; ?>

    <!-- Forma për shtimin e përdoruesit -->
    <form method="post" action="../get_set_data/set_users.php" class="add-user-form">
        <h3>Shto Përdorues të Ri</h3>
        <input type="text" name="name" placeholder="Emri" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Fjalëkalimi" required>
        <select name="role">
            <option value="client">Client</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="add_user">SHTO</button>
    </form>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Email</th>
                <th>Roli</th>
                <th>Veprime</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr id="user-row-<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <form method="post" action="../get_set_data/set_users.php" onsubmit="return confirm('Jeni i sigurt që doni të fshini këtë përdorues?');">
                        <input type="hidden" name="delete_user_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="delete-btn">Fshi</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

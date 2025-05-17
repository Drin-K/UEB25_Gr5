<?php
include("header.php");
include("sidebar.php");
include("db.php");

$updateMessage = "";
$addMessage = "";
$deleteMessage = "";

// Vetëm përditësimi i rolit përmes AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax']) && $_POST['ajax'] === 'update_role') {
    $userId = $_POST['user_id'] ?? 0;
    $role = $_POST['role'] ?? '';

    if (in_array($role, ['client', 'admin'])) {
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $role, $userId);
        $result = $stmt->execute();
        $stmt->close();
        echo $result ? "success" : "error";
    } else {
        echo "invalid_role";
    }
    exit;
}


// Shtimi i përdoruesit përmes formës standarde
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt->execute()) {
        $addMessage = "✅ Përdoruesi u shtua me sukses!";
    } else {
        $addMessage = "❌ Emaili ekziston ose ndodhi një gabim!";
    }
    $stmt->close();
}

// Fshirja e përdoruesit përmes POST (pa AJAX)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user_id'])) {
    $userId = $_POST['delete_user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $deleteMessage = "✅ Përdoruesi u fshi me sukses!";
    } else {
        $deleteMessage = "❌ Ndodhi një gabim gjatë fshirjes!";
    }
    $stmt->close();
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Menaxho Përdoruesit</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/users.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="content">
    <h2>Menaxhimi i Përdoruesve</h2>

    <?php if ($addMessage): ?><div class="alert"><?= $addMessage ?></div><?php endif; ?>
    <?php if ($deleteMessage): ?><div class="alert"><?= $deleteMessage ?></div><?php endif; ?>

    <!-- Forma për shtimin e përdoruesit -->
    <form method="post" class="add-user-form">
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
                <td>
                    <select class="role-select" data-user-id="<?= $row['id'] ?>">
                        <option value="client" <?= $row['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                        <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <span class="update-status" id="status-<?= $row['id'] ?>"></span>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('Jeni i sigurt që doni të fshini këtë përdorues?');">
                        <input type="hidden" name="delete_user_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="delete-btn">Fshi</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(".role-select").change(function () {
            var userId = $(this).data("user-id");
            var newRole = $(this).val();
            var status = $("#status-" + userId);
            status.text("⏳");

            $.post("manage_users.php", {
                ajax: "update_role",
                user_id: userId,
                role: newRole
            }, function (response) {
                if (response === "success") {
                    // Trego një ikonë suksesi për pak sekonda
                    status.text("✅");
                    setTimeout(function () {
                        status.text(""); // pastrohet pas 2 sekondave
                    }, 2000);
                } else {
                    // Në vend të ❌, vetëm largoje animacionin ose lëre bosh
                    status.hide().text("✅").fadeIn(200).delay(1500).fadeOut(400);
                }
            });
        });
    });
</script>


</body>
</html>

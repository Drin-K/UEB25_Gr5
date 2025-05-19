<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
include("sidebar.php");
include("db.php");

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

// Shto Membership të ri (pa duration)
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
}

// Përditëso Membership-in ekzistues
if (isset($_POST['edit_inline'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $name, $price, $id);
    $stmt->execute();
}

// Fshij Membership
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Merr të gjitha membership-et
$memberships = $conn->query("SELECT * FROM memberships");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menaxhimi i Anëtarësimeve</title>
    <link rel="stylesheet" href="../css/memberships.css">
    <script>  
    function enableEditing(rowId) {
        const row = document.getElementById(rowId);
        const inputs = row.querySelectorAll('.editable');
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.classList.add('highlight');
        });

        document.getElementById("edit-btn-" + rowId).style.display = "none";
        document.getElementById("save-btn-" + rowId).style.display = "inline-block";
    }
    </script>
</head>
<body>
<div class="content-container">
    <div class="membership-form">
        <h3>Shto Membership të Ri</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Emri i Membership-it" required>
            <input type="number" name="price" placeholder="Çmimi (€)" step="0.01" required>
            <button type="submit" name="add">Shto</button>
        </form>
    </div>

    <table class="membership-table">
        <thead>
            <tr>
                <th>Emri</th>
                <th>Çmimi</th>
                <th>Veprime</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $memberships->fetch_assoc()): ?>
            <tr id="row-<?= $row['id']; ?>">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <td><input type="text" name="name" class="editable" value="<?= htmlspecialchars($row['name']); ?>" readonly></td>
                    <td><input type="number" name="price" class="editable" value="<?= number_format($row['price'], 2); ?>" step="0.01" readonly></td>
                    <td>
                        <button type="button" id="edit-btn-row-<?= $row['id']; ?>" onclick="enableEditing('row-<?= $row['id']; ?>')">Ndrysho</button>
                        <button type="submit" name="edit_inline" id="save-btn-row-<?= $row['id']; ?>" style="display: none;">Ruaj</button>
                        <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('A jeni i sigurt?')">Fshij</a>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

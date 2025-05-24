<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../general/header.php");
include("../general/sidebar.php");
include("../db.php");

function handleDbError($msg, $stmt = null) {
    if ($stmt) {
        throw new Exception($msg . " " . $stmt->error);
    } else {
        throw new Exception($msg);
    }
}

$addMessage = "";
$editMessage = "";
$deleteMessage = "";

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        try {
            $stmt = $conn->prepare("INSERT INTO memberships (name, price) VALUES (?, ?)");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për insert.");

            $stmt->bind_param("sd", $name, $price);
            if (!$stmt->execute()) handleDbError("Gabim gjatë shtimit të membership-it.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $addMessage = $e->getMessage();
        }
    } else {
        $addMessage = "Emri ose çmimi nuk janë të vlefshëm.";
    }
}

if (isset($_POST['edit_inline'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($price) && $price > 0) {
        try {
            $stmt = $conn->prepare("UPDATE memberships SET name=?, price=? WHERE id=?");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për update.");

            $stmt->bind_param("sdi", $name, $price, $id);
            if (!$stmt->execute()) handleDbError("Gabim gjatë përditësimit.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $editMessage = $e->getMessage();
        }
    } else {
        $editMessage = "Të dhënat për përditësim janë të pavlefshme.";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (is_numeric($id)) {
        try {
            $stmt = $conn->prepare("DELETE FROM memberships WHERE id=?");
            if (!$stmt) handleDbError("Gabim gjatë përgatitjes për fshirje.");

            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) handleDbError("Gabim gjatë fshirjes.", $stmt);
            $stmt->close();
        } catch (Exception $e) {
            $deleteMessage = $e->getMessage();
        }
    }
}

$memberships = $conn->query("SELECT * FROM memberships");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menaxhimi i Anëtarësimeve</title>
    <link rel="stylesheet" href="../../css/memberships.css">
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
    <?php if ($addMessage): ?>
    <p style="color:red;"><?= htmlspecialchars($addMessage); ?></p>
<?php endif; ?>
<?php if ($editMessage): ?>
    <p style="color:red;"><?= htmlspecialchars($editMessage); ?></p>
<?php endif; ?>
<?php if ($deleteMessage): ?>
    <p style="color:red;"><?= htmlspecialchars($deleteMessage); ?></p>
<?php endif; ?>

</div>
</body>
</html>

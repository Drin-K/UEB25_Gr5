<?php
include("logic/membershipsLogic.php");
include("../general/header.php");
include("../general/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menaxhimi i Anëtarësimeve</title>
    <link rel="stylesheet" href="../../css/memberships.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="content-container">
    <div class="membership-form">
        <h3>Shto Membership të Ri</h3>
        <form method="POST" action="logic/membershipsLogic.php">
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
                <td><input type="text" class="editable" id="name-<?= $row['id']; ?>" value="<?= htmlspecialchars($row['name']); ?>" readonly></td>
                <td><input type="number" class="editable" id="price-<?= $row['id']; ?>" value="<?= number_format($row['price'], 2); ?>" step="0.01" readonly></td>
                <td>
                    <button type="button" onclick="edit(<?= $row['id']; ?>)">Ndrysho</button>
                    <button type="button" id="save-btn-<?= $row['id']; ?>" onclick="save(<?= $row['id']; ?>)" style="display:none;">Ruaj</button>
                    <a href="logic/membershipsLogic.php?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('A jeni i sigurt?')">Fshij</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div id="update-message" style="margin-top: 15px; color: green;"></div>
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

<script>
$(document).ready(function() {
    window.edit = function edit(id) {
        $('#name-' + id + ', #price-' + id).prop('readonly', false).addClass('highlight');
        $('#save-btn-' + id).show();
    }

    window.save = function(id) {
        const name = $('#name-' + id).val();
        const price = $('#price-' + id).val();

        $.ajax({
            url: 'logic/membershipsLogic.php',
            method: 'POST',
            data: {
                ajax_edit: 'ajax_edit',
                id: id,
                name: name,
                price: price
            },
            success: function(data) {
                $('#update-message').text(data).css('color', data.includes('sukses') ? 'green' : 'red');
                $('#name-' + id + ', #price-' + id).prop('readonly', true).removeClass('highlight');
                $('#save-btn-' + id).hide();
            },
            error: function() {
                $('#update-message').text('Gabim gjatë përditësimit!').css('color', 'red');
            }
        });
    }
});
</script>


</script>
</body>
</html>

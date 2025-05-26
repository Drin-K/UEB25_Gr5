<?php
include("../general/header.php");
include("../general/sidebar.php");
include("logic/profile_logic.php"); ?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../../css/profili.css">
    <style>
        .message.success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="profile-container">
            <h2>Profili Juaj</h2>

            <div class="profile-info">
                <div id="profile-message"></div>
                <form method="POST" id="profileForm" novalidate>
                    <div class="form-group">
                        <label>Emri:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($userData['Name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($userData['Email']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Data e Regjistrimit:</label>
                        <input type="text" name="created_at" value="<?= htmlspecialchars($userData['created_at']) ?>" disabled>
                    </div>

                    <button type="submit">Ruaj Ndryshimet</button>
                </form>
            </div>

            <div class="password-section">
                <h3>Ndrysho Fjalëkalimin</h3>

                <?php if ($passwordMessage): ?>
                    <div class="message <?= strpos(strtolower($passwordMessage), 'sukses') !== false ? 'success' : 'error' ?>">
                        <?= htmlspecialchars($passwordMessage) ?>
                    </div>
                <?php endif; ?>

                <form class="password-form" method="POST">
                    <div class="form-group">
                        <label>Fjalëkalimi Aktual:</label>
                        <input type="password" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label>Fjalëkalimi i Ri:</label>
                        <input type="password" name="new_password" required minlength="8">
                    </div>

                    <div class="form-group">
                        <label>Konfirmo Fjalëkalimin:</label>
                        <input type="password" name="confirm_password" required minlength="8">
                    </div>

                    <button type="submit" name="change_password">Ndrysho Fjalëkalimin</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#profileForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: 'update_profile_ajax.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                let messageType = response.toLowerCase().includes("sukses") ? "success" : "error";
                $('#profile-message').html('<div class="message ' + messageType + '">' + response + '</div>');
            },
            error: function(){
                $('#profile-message').html('<div class="message error">Gabim gjatë përditësimit të profilit.</div>');
            }
        });
    });
});
</script>
</body>
</html>

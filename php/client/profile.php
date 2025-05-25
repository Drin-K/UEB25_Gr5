<?php
include("../general/header.php");
include("../general/sidebar.php");
include("logic/profile_logic.php"); // përfshin logjikën dhe variablat si $userData, $successMessage, $passwordMessage
?>


<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../../css/profili.css">
</head>
<body>
    <div class="content">
        <div class="profile-container">
            <h2>Profili Juaj</h2>
            
           
            <div class="profile-info">
                <form method="POST" id="profileForm">
                    <div class="form-group">
                        <label>Emri:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($userData['Name']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($userData['Email']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Data e Regjistrimit:</label>
                        <input type="text" value="<?= htmlspecialchars($userData['created_at']) ?>" readonly>
                    </div>
                    
                    <button type="submit">Ruaj Ndryshimet</button>
                </form>
            </div>
            
            <div class="password-section">
                <h3>Ndrysho Fjalëkalimin</h3>
                
                <?php if ($passwordMessage): ?>
                    <div class="message <?= strpos($passwordMessage, 'success') !== false ? 'success' : 'error' ?>">
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
                $('.message.success, .message.error').remove();
                $('<div class="message success">' + response + '</div>').insertBefore('.profile-info');
            },
            error: function(){
                alert("Gabim gjatë përditësimit.");
            }
        });
    });
});
</script>

</body>
</html>
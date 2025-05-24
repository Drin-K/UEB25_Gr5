<?php
include("../general/header.php");
include("../general/sidebar.php");
include("../db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Function to get user data using MySQLi
function getUserData($userId, $conn) {
    $query = "SELECT Name, Email, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to update user data using MySQLi
function updateUserData($userId, $name, $email, $conn) {
    $query = "UPDATE users SET Name = ?, Email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $name, $email, $userId);
    return $stmt->execute();
}

// NEW FUNCTION: Change password
function changePassword($userId, $currentPass, $newPass, $conn) {
    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Verify current password
    if (!password_verify($currentPass, $user['password'])) {
        return "Current password is incorrect";
    }
    
    // Update password
    $newHash = password_hash($newPass, PASSWORD_DEFAULT);
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newHash, $userId);
    
    return $updateStmt->execute() ? true : $conn->error;
}

// Get current user data
$userData = getUserData($_SESSION['user_id'], $conn);

// Handle profile update
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    if (updateUserData($_SESSION['user_id'], $name, $email, $conn)) {
        $successMessage = "Profile updated successfully!";
        $userData = getUserData($_SESSION['user_id'], $conn);
    } else {
        $successMessage = "Error updating profile: " . $conn->error;
    }
}

// NEW: Handle password change
$passwordMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'])) {
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];
    
    if ($newPass !== $confirmPass) {
        $passwordMessage = "New passwords don't match";
    } elseif (strlen($newPass) < 8) {
        $passwordMessage = "Password must be at least 8 characters";
    } else {
        $result = changePassword($_SESSION['user_id'], $currentPass, $newPass, $conn);
        if ($result === true) {
            $passwordMessage = "Password changed successfully!";
        } else {
            $passwordMessage = "Error: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../../css/pagesat.css">
    <style>
    /* PROFILI - STIL FUTURISTIK */
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        background: rgba(10, 10, 10, 0.7);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(51, 204, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    h2 {
        color: var(--neon-green);
        margin-bottom: 30px;
        font-size: 2rem;
        text-shadow: 0 0 10px rgba(34, 255, 136, 0.3);
        position: relative;
        padding-bottom: 10px;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, var(--neon-green), var(--neon-blue));
    }

    .profile-info {
        margin-bottom: 40px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: var(--neon-blue);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    input {
        width: 100%;
        padding: 12px 15px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(51, 204, 255, 0.2);
        border-radius: 6px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    input:focus {
        outline: none;
        border-color: var(--neon-blue);
        box-shadow: 0 0 10px rgba(51, 204, 255, 0.3);
    }

    .readonly-field {
        background: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    button[type="submit"] {
        background: linear-gradient(135deg, var(--neon-green), var(--neon-blue));
        color: black;
        border: none;
        padding: 12px 25px;
        font-weight: bold;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 0 15px rgba(51, 204, 255, 0.3);
    }

    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 20px rgba(51, 204, 255, 0.5);
    }

    /* SEKSIONI I FJALËKALIMIT */
    .password-section {
        margin-top: 40px;
        padding: 25px;
        background: rgba(5, 5, 5, 0.6);
        border-radius: 10px;
        border: 1px solid rgba(34, 255, 136, 0.1);
        box-shadow: 0 0 15px rgba(34, 255, 136, 0.1);
    }

    .password-section h3 {
        color: var(--neon-green);
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .password-form input[type="password"] {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(34, 255, 136, 0.2);
    }

    .password-form input[type="password"]:focus {
        border-color: var(--neon-green);
        box-shadow: 0 0 10px rgba(34, 255, 136, 0.3);
    }

    /* MESAZHET */
    .message {
        padding: 15px;
        margin: 15px 0;
        border-radius: 6px;
        font-weight: 500;
        animation: fadeIn 0.5s ease;
    }

    .success {
        background: rgba(34, 255, 136, 0.1);
        color: var(--neon-green);
        border: 1px solid rgba(34, 255, 136, 0.3);
    }

    .error {
        background: rgba(255, 51, 102, 0.1);
        color: #ff3366;
        border: 1px solid rgba(255, 51, 102, 0.3);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ANIMACIONE */
    .profile-container {
        animation: glow 8s ease-in-out infinite alternate;
    }

    @keyframes glow {
        0% {
            box-shadow: 0 0 10px rgba(51, 204, 255, 0.1);
        }
        50% {
            box-shadow: 0 0 20px rgba(34, 255, 136, 0.2);
        }
        100% {
            box-shadow: 0 0 10px rgba(51, 204, 255, 0.1);
        }
    }
</style>
</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <div class="profile-container">
            <h2>Profili Juaj</h2>
            
            <?php if ($successMessage): ?>
                <div class="message success"><?= htmlspecialchars($successMessage) ?></div>
            <?php endif; ?>
            
            <div class="profile-info">
                <form method="POST">
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
            
            <!-- NEW PASSWORD CHANGE SECTION -->
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
</body>
</html>
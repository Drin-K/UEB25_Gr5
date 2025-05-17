<?php
include("header.php");
include("sidebar.php");
include("db.php");
// Your MySQLi connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

// Get current user data
$userData = getUserData($_SESSION['user_id'], $conn);

// Handle form submission
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    if (updateUserData($_SESSION['user_id'], $name, $email, $conn)) {
        $successMessage = "Profile updated successfully!";
        // Refresh user data
        $userData = getUserData($_SESSION['user_id'], $conn);
    } else {
        $successMessage = "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../css/pagesat.css">
</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <div class="profile-container">
            <h2>Profili Juaj</h2>
            
            <div class="profile-info">
                <div class="form-group">
                    <label>Emri:</label>
                    <input type="text" value="<?= htmlspecialchars($userData['Name']) ?>" class="readonly-field" readonly>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" value="<?= htmlspecialchars($userData['Email']) ?>" class="readonly-field" readonly>
                </div>
                
                <div class="form-group">
                    <label>Data e Regjistrimit:</label>
                    <input type="text" value="<?= htmlspecialchars($userData['created_at']) ?>" class="readonly-field" readonly>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
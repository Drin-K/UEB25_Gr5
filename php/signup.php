<?php  
require_once("db.php");
require_once("../php/general/error_handler.php");
session_start();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        trigger_error("Ju lutem plotësoni të gjitha fushat.", E_USER_WARNING);
        $error = "Ju lutem plotësoni të gjitha fushat.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        trigger_error("Email i pavlefshëm: $email", E_USER_WARNING);
        $error = "Email i pavlefshëm.";
    } elseif ($password !== $confirm_password) {
        trigger_error("Fjalëkalimet nuk përputhen.", E_USER_WARNING);
        $error = "Fjalëkalimet nuk përputhen.";
    } else {
        if ($stmt = $conn->prepare("SELECT id FROM users WHERE email = ?")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                trigger_error("Email i përdorur më parë: $email", E_USER_WARNING);
                $error = "Ky email është përdorur më parë.";
            } 
            $stmt->close();
        } else {
            trigger_error("Gabim në përgatitjen e query: " . $conn->error, E_USER_ERROR);
            $error = "Ndodhi një problem gjatë regjistrimit. Ju lutem provoni përsëri.";
        }

        if (empty($error)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'client';

            if ($stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("ssss", $name, $email, $password_hash, $role);

                if ($stmt->execute()) {
                    $success = "Regjistrimi u krye me sukses. Tani mund të kyçeni.";
                } else {
                    trigger_error("Gabim gjatë insertimit në DB: " . $stmt->error, E_USER_ERROR);
                    $error = "Ndodhi një problem gjatë regjistrimit. Ju lutem provoni përsëri.";
                }

                $stmt->close();
            } else {
                trigger_error("Gabim në përgatitjen e insert query: " . $conn->error, E_USER_ERROR);
                $error = "Ndodhi një problem gjatë regjistrimit. Ju lutem provoni përsëri.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Regjistrohu - ILLYRIAN Gym</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="signup-container animate__animated animate__fadeIn">
        <h2 class="animate__animated animate__fadeInDown">REGJISTROHU</h2>
        
        <?php if ($error): ?>
            <p class="error animate__animated animate__shakeX"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        
        <form action="signup.php" method="post" novalidate>
            <div class="input-group">
                <input type="text" name="username" id="username" placeholder=" " value="<?= htmlspecialchars($name ?? '') ?>" required>
                <label for="username"><i class="fas fa-user"></i> EMRI</label>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder=" " value="<?= htmlspecialchars($email ?? '') ?>" required>
                <label for="email"><i class="fas fa-envelope"></i> EMAIL</label>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password"><i class="fas fa-lock"></i> FJALËKALIMI</label>
            </div>
            
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirm_password" placeholder=" " required>
                <label for="confirm_password"><i class="fas fa-lock"></i> KONFIRMO FJALËKALIMIN</label>
            </div>
            
            <button type="submit" class="btn">REGJISTROHU</button>
        </form>
        
        <div class="login-link">
            Ke llogari? <a href="login.php">KYÇU KËTU</a>
            <br><br>
            <a href="index.php">Kthehu në faqe Kryesore</a>
        </div>
    </div>
</body>
</html>

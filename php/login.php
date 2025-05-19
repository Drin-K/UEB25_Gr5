<?php
require_once("db.php");
session_start();

// Kontrollo nëse ekziston cookie për auto-login
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    $cookie_data = explode(':', $_COOKIE['remember_user']);
    if (count($cookie_data) === 2) {
        $user_id = $cookie_data[0];
        $token = $cookie_data[1];
        
        // Merr të dhënat e përdoruesit nga DB
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verifiko token-in
            if (hash_equals(hash('sha256', $user['password']), $token)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header("Location: dashboard.php");
                exit();
            }
        }
        // Nëse cookie është i pavlefshëm, fshije
        setcookie('remember_user', '', time() - 3600, '/');
    }
}

$error = "";
$email = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]);

    if (empty($email) || empty($password)) {
        $error = "Ju lutem plotësoni të gjitha fushat.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                // Vendos cookie nëse përdoruesi zgjedh "Remember me"
                if ($remember) {
                    $token = $user['id'] . ':' . hash('sha256', $user['password']);
                    setcookie('remember_user', $token, time() + (86400 * 30), "/"); // 30 ditë
                    setcookie('remember_email', $email, time() + (86400 * 30), "/"); // Ruaj email për lehtësi
                } else {
                    // Fshi cookie-t nëse ekzistojnë
                    setcookie('remember_user', '', time() - 3600, '/');
                    setcookie('remember_email', '', time() - 3600, '/');
                }

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Email ose fjalëkalim i pasaktë.";
            }
        } else {
            $error = "Email ose fjalëkalim i pasaktë.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Login - ILLYRIAN Fitness</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container animate__animated animate__fadeIn">
        <h2 class="animate__animated animate__fadeInDown">ILLYRIAN GYM</h2>
        
        <?php if ($error): ?>
            <p class="error animate__animated animate__shakeX"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <form action="login.php" method="post" novalidate>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder=" " value="<?= htmlspecialchars($email) ?>" required>
                <label for="email"><i class="fas fa-envelope"></i> EMAIL</label>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password"><i class="fas fa-lock"></i> FJALËKALIMI</label>
            </div>
            
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Më mbaj mend</label>
            </div>
            
            <button type="submit" class="btn">KYÇU</button>
        </form>
        
        <div class="signup-link">
            Nuk ke llogari? <a href="signup.php">REGJISTROHU KËTU</a><br>
            <br>
            <a href="index.php">Kthehu në faqe Kryesore</a>
        </div>
    </div>
</body>
</html>
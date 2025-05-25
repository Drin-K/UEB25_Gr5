<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - ILLYRIAN Gym</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../css/header.css">
</head>
<body>
    <header>
        <a href="../admin&client/dashboard.php" class="logo">ILLYRIAN <span>GYM</span></a>
        
        <i class="fas fa-bars" id="menu-icon"></i>
        
        <nav id="navbar">
            <div class="user-menu">
                <span class="user-greeting">Mirë se erdhe, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <button class="logout-btn" onclick="window.location.href='../logout.php'">Dil</button>
            </div>
        </nav>
    </header>
    <body>
<script src="../../javascj/header.js"></script>

</body>
</html>
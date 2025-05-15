<?php 
// sidebar.php
$role = $_SESSION['role'] ?? 'klient';
?>

<html>
<head>
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
<div class="sidebar">
    <h3>Menu</h3>
    <ul>
        <?php if ($role === 'admin'): ?>
            <li class="important"><a href="manage_users.php"><i class="fas fa-users-cog"></i> Menaxho Përdoruesit</a></li>
            <li><a href="manage_memberships.php"><i class="fas fa-id-card"></i> Menaxho Memberships</a></li>
            <li><a href="manage_subscriptions.php"><i class="fas fa-receipt"></i> Menaxho Subscriptions</a></li>
            <li><a href="reports.php"><i class="fas fa-chart-line"></i> Raporte</a></li>
            <li><a href="system_settings.php"><i class="fas fa-cog"></i> Cilësimet</a></li>
        <?php else: ?>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="view_schedule.php"><i class="fas fa-calendar-alt"></i> Orari</a></li>
            <li><a href="my_reservations.php"><i class="fas fa-bookmark"></i> Rezervimet</a></li>
            <li><a href="workouts.php"><i class="fas fa-dumbbell"></i> Stërvitjet</a></li>
            <li><a href="nutrition.php"><i class="fas fa-utensils"></i> Ushqimi</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profili</a></li>
        <?php endif; ?>
    </ul>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="../javascj/sidebar.js"></script>
  </body></html>
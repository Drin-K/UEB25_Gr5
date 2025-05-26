<?php 
$role = $_SESSION['role'];
?>

<html>
<head>
    <link rel="stylesheet" href="../../css/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


</head>
<body>
<div class="sidebar">
    <h3>Menu</h3>
    <ul>
        <?php if ($role === 'admin'): ?>
            <li><a href="../admin/manage_users.php"><i class="fas fa-users-cog"></i> Menaxho Përdoruesit</a></li>
            <li><a href="../admin/manage_memberships.php"><i class="fas fa-id-card"></i> Menaxho Memberships</a></li>
            <li><a href="../admin/subscription.php"><i class="fas fa-receipt"></i> Menaxho Subscriptions</a></li>
            <li><a href="../admin/reports.php"><i class="fas fa-chart-line"></i> Raporte</a></li>
            <li><a href="../admin/adminUshtrimet.php"><i class="fas fa-dumbbell"></i> Ushtrimet</a></li>
              <li><a href="../admin&client/nutrition.php"><i class="fas fa-utensils"></i> Planet ushqimore</a></li>
        <?php else: ?>
             <li><a href="../client/anetaresimet.php"><i class="fas fa-bookmark"></i> Anëtarësimi</a></li>
            <li><a href="../client/pagesat.php"><i class="fas fa-calendar-alt"></i> Pagesat</a></li>
            <li><a href="../client/stervitjet.php"><i class="fas fa-dumbbell"></i> Stërvitjet</a></li>
            <li><a href="../admin&client/nutrition.php"><i class="fas fa-utensils"></i> Ushqimi</a></li>
            <li><a href="../client/bmiCalculator.php"><i class="fas fa-calculator"></i> BMI Calculator</a></li>
            <li><a href="../client/profile.php"><i class="fas fa-user"></i> Profili</a></li>
        <?php endif; ?>
    </ul>
</div>



<script src="../javascj/sidebar.js"></script>
  </body></html>
<?php
include 'headers.php';
include 'db.php'; // Sigurohu që lidhet me databazën

// Merr membership-et nga databaza
$result = $conn->query("SELECT * FROM memberships");

$memberships = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $memberships[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <title><?php echo SITE_NAME ?></title>
<style>
    .special-offer {
    background: linear-gradient(135deg, #f39c12, #d35400);
    color: #fff !important;
    border: 3px solid #e67e22;
    box-shadow: 0 0 15px rgba(243, 156, 18, 0.6);
    position: relative;
    transition: transform 0.3s ease;
}

.special-offer:hover {
    transform: scale(1.05);
}

.ribbon {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    color: white;
    padding: 5px 10px;
    font-weight: bold;
    transform: rotate(10deg);
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    border-radius: 5px;
    z-index: 20;
}
.box {
    position: relative;
}

</style>
   
</head>
<body>
<header>
    <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF'])); ?>
    </ul>
    <div class="top-btn">
        <a href="login.php" class="nav-btn">Join Us</a>
    </div>
    <div class="senvichi">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <script src="../javascj/javascript.js"></script>
</header>

<section class="plans" id="plans">
    <h2 class="heading">Our <span>Plans</span></h2>
    <div class="plans-content">
        <?php foreach ($memberships as $index => $plan): ?>
            <div class="box <?= $index > 2 ? 'special-offer' : '' ?>" id="p<?= $index + 1 ?>">
                <?php if ($index > 2): ?>
                    <div class="ribbon">Special Offer</div>
                <?php endif; ?>

                <h3><?= htmlspecialchars($plan['name']) ?></h3>
                <h2><span>$<?= number_format($plan['price'], 2) ?>/Month</span></h2>
                <ul>
                    <li style="list-style-type: none;">Smart workout plan</li>
                    <?php if ($plan['price'] >= 50): ?>
                        <li style="list-style-type: none;">Pro Gyms</li>
                    <?php endif; ?>
                    <?php if ($plan['price'] >= 70): ?>
                        <li style="list-style-type: none;">Elite Gyms & Classes</li>
                        <li style="list-style-type: none;">Personal Training</li>
                    <?php endif; ?>
                    <li style="list-style-type: none;">At home workouts</li>
                </ul>
                <a href="login.php">
                    Join Now
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    <?php foreach ($memberships as $index => $plan): ?>
        $("#p<?= $index + 1 ?>").click(function () {
            <?php foreach ($memberships as $i => $ignore): ?>
                <?php if ($i !== $index): ?>
                    $("#p<?= $i + 1 ?>").hide();
                <?php endif; ?>
            <?php endforeach; ?>

            $("#p<?= $index + 1 ?>").css({
                transform: "translateX(29vw)",
                position: "relative",
                zIndex: 10
            });
        });
    <?php endforeach; ?>
</script>

</body>
</html>

<?php
include 'headers.php';
require_once("../db.php");

class Stats {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }
    private function getCount($table, $where = '') {
        $sql = "SELECT COUNT(*) AS total FROM $table" . ($where ? " WHERE $where" : "");
        $res = $this->conn->query($sql);
        return ($res && $row = $res->fetch_assoc()) ? (int)$row['total'] : 0;
    }
    public function countClients()       { return $this->getCount('users', "role='client'"); }
    public function countNutritionPlans(){ return $this->getCount('nutrition_plans'); }
    public function countMemberships()   { return $this->getCount('memberships'); }
}

$stats = new Stats($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../../css/style.css" />
    <title><?= SITE_NAME ?> - Services Stats</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
<header>
    <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar"><?= generateMenu($menu_items, basename($_SERVER['PHP_SELF'])); ?></ul>
    <div class="top-btn"><a href="../login.php" class="nav-btn">Log in</a></div>
</header>

<section id="stats" class="home">
    <div class="home-content" style="max-width:500px;margin:50px auto;text-align:center;">
        <h1>System Statistics</h1>
        <div class="stat" style="margin:20px 0;font-size:1.3rem;color:#45ffca;">
            Clients in system: <span><?= $stats->countClients(); ?></span>
        </div>
        <div class="stat" style="margin:20px 0;font-size:1.3rem;color:#45ffca;">
            Nutrition Plans: <span><?= $stats->countNutritionPlans(); ?></span>
        </div>
        <div class="stat" style="margin:20px 0;font-size:1.3rem;color:#45ffca;">
            Memberships: <span><?= $stats->countMemberships(); ?></span>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="social">
        <a href="https://www.instagram.com" target="_blank"><img src="../../fotot1/instagram.jpg" alt="Instagram"></a>
        <a href="https://www.facebook.com" target="_blank"><img src="../../fotot1/facebook.jpg" alt="Facebook"></a>
        <a href="https://www.linkedin.com" target="_blank"><img src="../../fotot1/linkedin.jpg" alt="LinkedIn"></a>
    </div>
    <p class="copyright">&copy; <?= date("Y") . " " . SITE_NAME; ?></p>
</footer>

<script src="../../javascj/javascript.js"></script>
<script>
$(function() {
    $(".social a").click(function(e) {
        if (!confirm("Would you like to continue to the site?")) e.preventDefault();
        else alert($(this).attr("href"));
    });
});
</script>
</body>
</html>

<?php
include 'headers.php';
require_once("../db.php");

class Stats {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function countClients(): int {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'client'";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }
    public function countNutritionPlans(): int {
        $sql = "SELECT COUNT(*) AS total FROM nutrition_plans";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    public function countMemberships(): int {
        $sql = "SELECT COUNT(*) AS total FROM memberships";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }
}

$stats = new Stats($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../../css/style.css" />
    <title><?php echo SITE_NAME ?> - Services Stats</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
    <header>
        <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF'])); ?>
        </ul>
        <div class="top-btn">
            <a href="../login.php" class="nav-btn">Log in</a>
        </div>
      
    </header>

    <section id="stats" class="home">
        <div class="home-content" style="max-width: 500px; margin: 50px auto; text-align: center;">
            <h1>System Statistics</h1>

            <div class="stat" style="margin: 20px 0; font-size: 1.3rem; color: #45ffca;">
                Clients in system: <span><?php echo $stats->countClients(); ?></span>
            </div>

            <div class="stat" style="margin: 20px 0; font-size: 1.3rem; color: #45ffca;">
                Nutrition Plans: <span><?php echo $stats->countNutritionPlans(); ?></span>
            </div>

            <div class="stat" style="margin: 20px 0; font-size: 1.3rem; color: #45ffca;">
                Memberships: <span><?php echo $stats->countMemberships(); ?></span>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="social">
            <a href="https://www.instagram.com" target="_blank"><img src="../../fotot1/instagram.jpg" alt="Instagram"></a>
            <a href="https://www.facebook.com" target="_blank"><img src="../../fotot1/facebook.jpg" alt="Facebook"></a>
            <a href="https://www.linkedin.com" target="_blank"><img src="../../fotot1/linkedin.jpg" alt="LinkedIn"></a>
        </div>

        <p class="copyright">
            &copy; <?php echo date("Y") . " " . SITE_NAME; ?>
        </p>
    </footer>

    <script src="../../javascj/javascript.js"></script>
    <script>
        $(document).ready(function () {
            $(".social a").click(function (event) {
                var link = $(this).attr("href");
                var confirmation = confirm("Would you like to continue to the site?");
                if (confirmation) {
                    alert(link);
                } else {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>

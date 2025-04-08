<?php
include 'headers.php';
// Vargu asociativ për planet dhe çmimet
$plans = [
    "BASIC" => 30,
    "PRO" => 50,
    "PREMIUM" => 70
];

// Aktivizo var_dump për debugging vetëm kur je në mjedisin e zhvillimit
$debug_mode = true; // Vendos këtë në true për debugging

if ($debug_mode) {
    echo "<div style='display:none;'>";
    echo "<pre>";
    var_dump($plans); // Var_dump për të parë çmimet e planeve
    echo "</pre>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <title>ILLYRIAN Gym</title>
</head>
<body>
    <header>
        <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>

        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
        <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF']));?>
        </ul>

        <div class="top-btn">
            <a href="joinus.php" class="nav-btn">Join Us</a>
        </div>
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
            <div class="box" id="p1">
                <h3>BASIC</h3>
                <h2><span>$30/Month</span></h2>
                <ul>
                    <li style="list-style-type: none;"><input type="checkbox"> Smart workout plan</li>
                    <li style="list-style-type: none;"><input type="checkbox"> At home workouts</li>
                </ul>
                <a href="joinus.php">
                    Join Now
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="box" id="p2">
                <h3>PRO</h3>
                <h2><span>$50/Month</span></h2>
                <ul>
                    <li style="list-style-type: none;"><input type="checkbox"> Pro GYMS</li>
                    <li style="list-style-type: none;"><input type="checkbox"> Smart workout plan</li>
                    <li style="list-style-type: none;"><input type="checkbox"> At home workouts</li>
                </ul>
                <a href="joinus.php">
                    Join Now
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="box" id="p3">
                <h3>PREMIUM</h3>
                <h2><span>$70/Month</span></h2>
                <ul>
                    <li style="list-style-type: none;"><input type="checkbox"> ELITE Gyms & Classes</li>
                    <li style="list-style-type: none;"><input type="checkbox"> Pro GYMS</li>
                    <li style="list-style-type: none;"><input type="checkbox"> Smart workout plan</li>
                    <li style="list-style-type: none;"><input type="checkbox"> At home workouts</li>
                    <li style="list-style-type: none;"><input type="checkbox"> Personal Training</li>
                </ul>
                <a href="joinus.php">
                    Join Now
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </section>

    <script>
        $("#p1").click(function () {
            $("#p2, #p3").hide();
    
            $("#p1").css({
                transform: "translateX(29vw)",  
                zIndex: 10                    
            });
        });
    
        $("#p2").click(function () {
            $("#p1, #p3").hide();
    
            $("#p2").css({
                transform: "translateX(29vw)", 
                position: "relative",        
                zIndex: 5                   
            });
        })
        
        $("#p3").click(function () {
            $("#p1, #p2").hide();  
    
            $("#p3").css({
                position: "relative",           
                left: "160%",                   
                transform: "translateX(-50%)",  
                zIndex: 5                       
            });
    
            setTimeout(function() {
                $("#p3").css({
                    left: "160%",                    
                    transform: "translateX(-50%)",  
                });
            }, 10); 
        });
    </script>
</body>
</html>

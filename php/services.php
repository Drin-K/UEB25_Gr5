<?php 
// Klasa bazë për shërbimet
class Service {
    protected string $image;
    protected string $title;
    private static int $serviceCount = 0; 
    public function __construct(string $image, string $title) {
    $this->image = $image;
    $this->title = $title;
    self::$serviceCount++; 
    }
    // Destruktori (Opsional - për të treguar kur shërbimi shkatërrohet)
    public function __destruct() {
    self::$serviceCount--; 
    }
    
    // GET dhe SET për titullin
    public function getTitle(): string {
    return $this->title;
    }
    public function setTitle(string $title): void {
    $this->title = $title;
    }
    // GET për numrin total të shërbimeve
    public static function getServiceCount(): int {
    return self::$serviceCount;
    }
    public function displayService(): string {
    return "
    <div class='row'>
    <img src='{$this->image}' alt='{$this->title}'>
    <h4>{$this->title}</h4>
    </div>";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ILLYRIAN Gym</title>
</head>
<body>
    <header>
            <a href="index.html" class="logo">ILLYRIAN <span>Gym</span></a>
    
            <div class="bx bx-menu" id="menu-icon"></div>
    
            <ul class="navbar">
                <li><a href="index.php" >Home</a></li>
                <li><a href="services.php" style="color:aquamarine;  border-bottom: 3px solid var(--main-color);">Services</a></li>
                <li><a href="diet.html">Diet</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="plans.html">Pricing</a></li>
                <li><a href="Workouts.html">Workouts</a></li>
                <li><a href="review.html">Review</a></li>
            </ul>
    
            <div class="top-btn">
                <a href="joinus.html" class="nav-btn">Join Us</a>
            </div>
            
            <div class="senvichi">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <script src="../javascj/javascript.js"></script>
    </header>
    <section class="services" id="services">
<h2 class="heading">Our <span>Services</span></h2>
<!-- Shfaq numrin total të shërbimeve -->
<h5>Total Services Offered: <?php echo
Service::getServiceCount(); ?></h5>
<div class="services-content">
<?php
// Shfaq shërbimet normale
foreach ($services as $service) {
echo $service->displayService();
}
// Shfaq shërbimet premium me një ndarje vizuale
echo "<h2 class='heading'>Premium <span>Services</span></h2>";
foreach ($premiumServices as $premiumService) {
echo $premiumService->displayService();
}
?>
</div>
</section>
</body>
</html>
<?php
include 'headers.php';
// Definimi i konstantave dhe variablave
define("SITE_NAME", "ILLYRIAN Gym");
$menu_items = [
"index.php" => "Home",
"services.php" => "Services",
"diet.php" => "Diet",
"about.php" => "About Us",
"plans.php" => "Pricing",
"workouts.php" => "Workouts",
"review.php" => "Review"
];
// Funksion për të gjeneruar menunë
function generateMenu($items, $activePage) {
$menuHtml = "";
foreach ($items as $link => $title) {
$activeClass = ($link === $activePage) ? 'style="color:aquamarine; border-bottom: 3px solid var(--main-color);"' : '';
$menuHtml .= "<li><a href='$link' $activeClass>$title</a></li>";
}
return $menuHtml;
}
// Klasa bazë për shërbimet
class Service {
protected string $image;
protected string $title;
private static int $serviceCount = 0; // Numëron totalin e shërbimeve
public function __construct(string $image, string $title) {
$this->image = $image;
$this->title = $title;
self::$serviceCount++; // Inkremento numrin e shërbimeve
}
// Destruktori (Opsional - për të treguar kur shërbimi shkatërrohet)
public function __destruct() {
self::$serviceCount--; // Ul numrin e shërbimeve kur një objekt fshihet
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
// Klasa e specializuar për shërbimet premium (trashëgon nga Service)
class PremiumService extends Service {
private string $description;
public function __construct(string $image, string $title, string $description) {
parent::__construct($image, $title);
$this->description = $description;
}
// GET dhe SET për përshkrimin
public function getDescription(): string {
return $this->description;
}
public function setDescription(string $description): void {
$this->description = $description;
}
public function displayService(): string {

return "
<div class='row premium'>
<img src='{$this->image}' alt='{$this->title}'>
<h4>{$this->title} <span style='color: gold;'>(Premium)</span></h4>
<p>{$this->description}</p>
</div>";
}
}
// Lista e shërbimeve të zakonshme
$services = [
new Service("../fotot1/c670cb02d9db41a0af7680a6c1fdc55a.jpg","Weightlifting"),
new Service("../fotot1/woman-running-hard-sweating-37785236.webp","Running"),
new Service("../fotot1/calisthenics-feature.jpg", "Calisthenics"),
];
// Lista e shërbimeve premium
$premiumServices = [
    new PremiumService("../fotot1/jump-roping-total-body-workout-0-1516282424.jpg",
    "Physical Fitness","Tailored fitness programs designed to improve overall health, endurance, and flexibility."),
    new PremiumService("../fotot1/Pro-Boxing-Gallery2.png", "Boxing","Intense boxing workouts focused on technique, strength, and agility to enhance performance."),
    new PremiumService("../fotot1/Fitness Strenght.jpg", "Strength Training","Progressive weightlifting and resistance exercises aimed at building muscle and increasing strength."),
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">
<title><?php echo SITE_NAME; ?></title>
</head>
<body>
<header>
<a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
<div class="bx bx-menu" id="menu-icon"></div>
<ul class="navbar">
<?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF'])); ?>
</ul>

<div class="top-btn">
<a href="joinus.php" class="nav-btn">Join Us</a>
</div>
<div class="senvichi">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        
</header>
<script src="../javascj/javascript.js"></script>
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
echo "<br/>";
echo "<h2 class='heading'>Premium <span>Services</span></h2>";
echo "<br/>";
foreach ($premiumServices as $premiumService) {
echo $premiumService->displayService();
}
?>

</div>
</section>

</body>
</html>
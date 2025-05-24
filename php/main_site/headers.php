<?php
// Definimi i konstantave dhe variablave
const SITE_NAME = "ILLYRIAN Gym";
//vargu asociativ
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

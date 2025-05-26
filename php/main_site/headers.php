<?php

const SITE_NAME = "ILLYRIAN Gym";

$home = "Home";
$statistics = "Statistics";
$diet = "Diet";
$about = "About Us";
$plans = "Pricing";
$workouts = "Workouts";

$menu_items = [
    "index.php"     => &$home,
    "statistics.php"=> &$statistics,
    "diet.php"      => &$diet,
    "about.php"     => &$about,
    "plans.php"     => &$plans,
    "workouts.php"  => &$workouts
];


function &getActiveClass(string $link, string $activePage): string {
    $active = ($link === $activePage)
        ? 'style="color:aquamarine; border-bottom: 3px solid var(--main-color);"'
        : '';
    return $active;
}

function generateMenu(array &$items, string $activePage): string {
    $menuHtml = "";
    foreach ($items as $link => &$title) { 
        $activeClass =& getActiveClass($link, $activePage); 
        $menuHtml .= "<li><a href='$link' $activeClass>$title</a></li>";
        if ($title === "About Us") {
            unset($title); 
        }
    }
    return $menuHtml;
}
?>
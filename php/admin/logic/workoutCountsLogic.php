<?php
$allWorkouts = ['Back', 'Bicep', 'Tricep', 'Leg', 'Shoulder'];
$counts = [];

foreach ($allWorkouts as $w) {
    $cookieName = "count_$w";
    $counts[$w] = isset($_COOKIE[$cookieName]) ? (int)$_COOKIE[$cookieName] : 0;
}

// Rendit sipas përdorimit në mënyrë zbritëse
arsort($counts);

// Kthe array-n për përdorim te klienti
return $counts;

<?php
$allWorkouts = ['Back', 'Bicep', 'Tricep', 'Leg', 'Shoulder'];
$counts = [];

foreach ($allWorkouts as $w) {
    $cookieName = "count_$w";
    $counts[$w] = isset($_COOKIE[$cookieName]) ? (int)$_COOKIE[$cookieName] : 0;
}


arsort($counts);


return $counts;

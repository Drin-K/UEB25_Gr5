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
//Vargjet numerike
$lean_protein = ["Chicken", "Turkey", "Salmon", "Eggs", "Tofu", "Greek Yogurt"];
$carbs = ["Rice", "Potatoes", "Oats", "Beans", "Pasta", "Rice cakes"];
$fats = ["Avocado", "Peanut butter", "Olive oil", "Cheese", "Dark chocolate"];
$fruits_veggies = ["Broccoli", "Carrots", "Zucchini", "Apples", "Bananas", "Spinach"];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ILLYRIAN Gym</title>
    <style>
        table {
    width: 100%;
    border-collapse: separate; 
    border-spacing: 5px;
    margin: 30px 0;
}

th, td {
    border: 1px solid #ffffff;
    border-radius: 10px; 
    padding: 15px;
    text-align: left;
    background: var(--bg-color);
}

body {
    background: var(--bg-color);
    color: var(--text-color);
    margin: 100px;
}

h1 {
    color: rgb(0, 255, 234);
}

ul {
    padding-left: 10px;
}

th {
    color: var(--text-color);
    font-size: 18px;
}

td {
    vertical-align: top;
    font-size: 14px;
}
    </style>
</head>
<body>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ILLYRIAN Gym</title>
</head>

<body>
    <header>
        <a href="index.php" class="logo"><?php echo SITE_NAME;?></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF']));?>
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
<div class = "diet" data-aos="zoom-in">
<h1>Balance food plate for weight loss</h1>
<table>
    <thead>
        <tr>
            <th>Lean Protein</th>
            <th>Carbs</th>
            <th>Fats</th>
            <th>Fruits/Veggies</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <ul>
                    <li>Chicken / turkey breast</li>
                    <li>Ground turkey</li>
                    <li>Extra lean ground beef</li>
                    <li>Salmon</li>
                    <li>
                        White fish
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Tilapia</li>
                            <li style="list-style-type: disc;">Cod</li>
                            <li style="list-style-type: disc;">Tuna</li>
                        </ul>
                    </li>
                    <li>Shrimp</li>
                    <li>Eggs/Egg Whites</li>
                    <li>Tofu (Vegan)</li>
                    <li>Tempeh (Vegan)</li>
                    <li>Low-fat Greek yogurt</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>
                        Rice
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Brown</li>
                            <li style="list-style-type: disc;">White</li>
                        </ul>
                    </li>
                    <li>Green peas</li>
                    <li>Lentils</li>
                    <li>Whole grain bread</li>
                    <li>English muffins</li>
                    <li>Whole grain wraps/tortillas</li>
                    <li>Oats</li>
                    <li>Potatoes</li>
                    <li>
                        Beans
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Black beans</li>
                            <li style="list-style-type: disc;">Chickpeas</li>
                        </ul>
                    </li>
                    <li >Pasta</li>
                    <li >Rice cakes</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>Avocado</li>
                    <li>Peanut butter/almond butter</li>
                    <li>
                        Nuts
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Almonds</li>
                            <li style="list-style-type: disc;">Peanuts</li>
                            <li style="list-style-type: disc;">Cashews</li>
                        </ul>
                    </li>
                    <li>Olive oil</li>
                    <li>Coconut oil</li>
                    <li>Dark chocolate</li>
                    <li>Cheese</li>
                    <li>Chia seeds / flax seeds</li>
                    <li>Hummus</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>Broccoli</li>
                    <li>Cauliflower</li>
                    <li>Asparagus</li>
                    <li>
                        Leafy greens
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Mixed greens</li>
                            <li style="list-style-type: disc;">Lettuce</li>
                            <li style="list-style-type: disc;">Spinach</li>
                        </ul>
                    </li>
                    <li>Zucchini</li>
                    <li>Carrots</li>
                    <li>Bell peppers</li>
                    <li>Brussel sprouts</li>
                    <li>Mushrooms</li>
                    <li>Onions</li>
                    <li>Apples</li>
                    <li>Bananas</li>
                    <li>Oranges</li>
                    <li>
                        Berries
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li style="list-style-type: disc;">Blueberries</li>
                            <li style="list-style-type: disc;">Raspberries</li>
                        </ul>
                    </li>
                    <li>Pear</li>
                    <li>Watermelon</li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<h1>Balance food plate for bulk</h1>

<table>
    <thead>
        <tr>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
            <th>Snacks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <ul>
                    <li>4 egg whites</li>
                    <li>2 English muffins</li>
                    <li>32g Peanut butter</li>
                    <li>8 oz fat-free milk</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>1 can of tuna</li>
                    <li>290g brown rice</li>
                    <li>11g butter</li>
                    <li>100g green beans</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>6 oz of calf beef</li>
                    <li>12 oz sweet potato</li>
                    <li>Large green salad</li>
                    <li>20g salad dressing</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>1 scoop of protein powder</li>
                    <li>150g plain fat-free Greek Yogurt</li>
                    <li>75g frozen blueberries</li>
                    <li>1 granola bar</li>
                    <li>1 oz almonds</li>
                </ul>
            </td>
        </tr>
    </tbody>
</table>




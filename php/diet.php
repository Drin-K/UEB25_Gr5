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

// Funksionet e sortimit
function sortFoods(&$array, $method) {
    switch ($method) {
        case 'sort':
            sort($array); // rendit alfabetikisht
            break;
        case 'rsort':
            rsort($array); // rendit në mënyrë zbritëse
            break;
        case 'asort':
            asort($array); // ruan çelësin dhe rendit sipas vlerës
            break;
        case 'ksort':
            ksort($array); // rendit sipas çelësit
            break;
        case 'arsort':
            arsort($array); // ruan çelësin dhe rendit në mënyrë zbritëse sipas vlerës
            break;
        case 'krsort':
            krsort($array); // rendit në mënyrë zbritëse sipas çelësit
            break;
        default:
            echo "Method not supported.";
            break;
    }
}
// Thirrje e funksionit për çdo metodë sortimi
sortFoods($lean_protein, 'sort');     // Sortim në mënyrë alfabetike
sortFoods($carbs, 'rsort');          // Sortim në mënyrë zbritëse
sortFoods($fats, 'arsort');           // Sortim sipas vlerës (ruan çelësat)
sortFoods($fruits_veggies, 'krsort'); // Sortim sipas çelësave


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
    <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF']));?>
      </ul>
        <div class="top-btn">
            <a href="joinus.php" class="nav-btn">Join Us</a>
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
                <?php foreach ($lean_protein as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>                    <ul>
                        <?php foreach ($carbs as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php foreach ($fats as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php foreach ($fruits_veggies as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
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
                 <?php
                        $breakfast = ["4 egg whites", "2 English muffins", "32g Peanut butter", "8 oz fat-free milk"];
                        sortFoods($breakfast, 'sort');
                        foreach ($breakfast as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $lunch = ["1 can of tuna", "290g brown rice", "11g butter", "100g green beans"];
                        sortFoods($lunch, 'rsort'); 
                        foreach ($lunch as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $dinner = ["6 oz of calf beef", "12 oz sweet potato", "Large green salad", "20g salad dressing"];
                        sortFoods($dinner, 'asort'); 
                        foreach ($dinner as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $snacks = ["1 scoop of protein powder", "150g plain fat-free Greek Yogurt", "75g frozen blueberries", "1 granola bar", "1 oz almonds"];
                        sortFoods($snacks, 'ksort'); 
                        foreach ($snacks as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>

    </tbody>
    </table>
</div>

</div>

<?php  
// Definimi i array-ve multidimensional për dietën
$diets = [
    "weight_loss" => [
        "Lean Protein" => [
            "Chicken / turkey breast",
            "Ground turkey",
            "Extra lean ground beef",
            "Salmon",
            "Tilapia",
            "Cod",
            "Tuna",
            "Shrimp",
            "Eggs/Egg Whites",
            "Tofu (Vegan)",
            "Tempeh (Vegan)",
            "Low-fat Greek yogurt"
        ],
        "Carbs" => [
            "Rice" => ["Brown", "White"],
            "Green peas",
            "Lentils",
            "Whole grain bread",
            "English muffins",
            "Whole grain wraps/tortillas",
            "Oats",
            "Potatoes",
            "Black beans",
            "Chickpeas",
            "Pasta",
            "Rice cakes"
        ],
        "Fats" => [
            "Avocado",
            "Peanut butter/almond butter",
            "Almonds",
            "Peanuts",
            "Cashews",
            "Olive oil",
            "Coconut oil",
            "Dark chocolate",
            "Cheese",
            "Chia seeds / flax seeds",
            "Hummus"
        ],
        "Fruits_Veggies" => [
            "Broccoli",
            "Cauliflower",
            "Asparagus",
            "Mixed greens",
            "Lettuce",
            "Spinach",
            "Zucchini",
            "Carrots",
            "Bell peppers",
            "Brussel sprouts",
            "Mushrooms",
            "Onions",
            "Apples",
            "Bananas",
            "Oranges",
            "Blueberries",
            "Raspberries",
            "Pear",
            "Watermelon"
        ]
    ],
    "bulk" => [
        "Breakfast" => [
            "4 egg whites",
            "2 English muffins",
            "32g Peanut butter",
            "8 oz fat-free milk"
        ],
        "Lunch" => [
            "1 can of tuna",
            "290g brown rice",
            "11g butter",
            "100g green beans"
        ],
        "Dinner" => [
            "6 oz of calf beef",
            "12 oz sweet potato",
            "Large green salad",
            "20g salad dressing"
        ],
        "Snacks" => [
            "1 scoop of protein powder",
            "150g plain fat-free Greek Yogurt",
            "75g frozen blueberries",
            "1 granola bar",
            "1 oz almonds"
        ]
    ]
];


// Përdorimi i array-ve multidimensional për të shfaqur informacionin
echo "<h1>Diet for Weight Loss</h1>";
echo "<table border='1'>";
echo "<tr><th>Lean Protein</th><th>Carbs</th><th>Fats</th><th>Fruits/Veggies</th></tr>";
echo "<tr>";
foreach ($diets['weight_loss'] as $category => $items) {
    echo "<td><ul>";
    foreach ($items as $item => $value) {
        if (is_array($value)) {
            echo "<li>$item<ul>";
            foreach ($value as $subitem) {
                echo "<li>$subitem</li>";
            }
            echo "</ul></li>";
        } else {
            echo "<li>$value</li>";
        }
    }
    echo "</ul></td>";
}
echo "</tr>";
echo "</table>";


echo "<h1>Diet for Bulk</h1>";
echo "<table border='1'>";
echo "<tr><th>Breakfast</th><th>Lunch</th><th>Dinner</th><th>Snacks</th></tr>";
echo "<tr>";
foreach ($diets['bulk'] as $category => $items) {
    echo "<td><ul>";
    foreach ($items as $item) {
        echo "<li>$item</li>";
    }
    echo "</ul></td>";
}
echo "</tr>";
echo "</table>";
?>


</body>
</html>

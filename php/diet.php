<?php
// Definimi i konstantave dhe variablave
include 'headers.php';
define("SLASH_NAME","FruitsVeggies");

$oneletterword = "1"; //Perdorimi i strlen per te zevendesuar
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

sortFoods($lean_protein,'sort');//sort($lean_protein);    
sortFoods($carbs,'rsort');//rsort($carbs);       
sortFoods($fats,'sort');//sort($fats);       
sortFoods($fruits_veggies,'rsort');//rsort($fruits_veggies); 
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
            <th><?php echo addcslashes(SLASH_NAME,"V") ?></th>
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
                        sortFoods($breakfast,'sort');
                        foreach ($breakfast as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $lunch = [strlen($oneletterword)." can of tuna", "290g brown rice", "11g butter", "100g green beans"];
                        sortFoods($lunch,'rsort');
                        foreach ($lunch as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $dinner = ["6 oz of calf beef", "12 oz sweet potato", "Large green salad", "20g salad dressing"];
                        sortFoods($dinner,'rsort');
                        foreach ($dinner as $food): ?>
                            <li><?php echo $food; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php
                        $snacks = [strlen($oneletterword)." scoop of protein powder", "150g plain fat-free Greek Yogurt", "75g frozen blueberries", strlen($oneletterword)." granola bar", strlen($oneletterword)." oz almonds"];
                        sortFoods($snacks,'sort');
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
    "Maintenance Diet" => [
        "Lean Protein" => [
            "Grilled chicken breast",
            "Turkey slices (low sodium)",
            "Lean beef steak",
            "Crab meat",
            "Boiled eggs / egg whites",
            "Cottage cheese (low-fat)"
        ],
        "Carbs" => [
            "Rice" => ["Basmati", "Jasmine"],
            "Sweet corn",
            "Kidney beans",
            "Ezekiel bread",
            "Whole wheat bagels",
            "Whole grain pasta",
            "Quinoa"
        ],
        "Fats" => [
            "Guacamole",
            "Sunflower seed butter",
            "Brazil nuts",
            "Macadamia nuts",
            "Avocado oil",
            "Ghee (clarified butter)",
            "Nut-based protein bars",
            "Pumpkin seeds / hemp seeds"
        ],
        "Fruits_Veggies" => [
            "Kale",
            "Green beans",
            "Red cabbage",
            "Grapefruit",
            "Blackberries",
            "Strawberries",
            "Kiwi",
            "Cantaloupe"
        ]
        ],
    "Athlete" => [
        "Carbs" => [
            "Oats",
            "Brown rice",
            "Whole grain bread/pasta",
            "Sweet potatoes",
            "Bananas, apples, berries"
        ],
        "Protein" => [
            "Chicken breast",
            "Turkey",
            "Eggs",
            "Tuna, salmon"
        ],
        "Fats" => [
            "Avocados",
            "Nuts (almonds, walnuts)",
            "Seeds (chia, flaxseed)",
            "Fatty fish (like salmon)"
        ],
        "Hydration" => [
            "Water (main source)",
            "Electrolyte drinks (during/after training)",
            "Coconut water",
            "Fruits with high water content (watermelon, oranges)"
        ]
    ]
];

$carbohidrates = "Carbohidrates";
// Përdorimi i array-ve multidimensional për të shfaqur informacionin
echo "<h1>Maintenance Diet </h1>";
echo "<table border='1'>";
echo "<tr><th>Lean Protein</th><th>".str_replace("Carbohidrates","Carbs",$carbohidrates)."</th><th>Fats</th><th>".addcslashes(SLASH_NAME,"V")."</th></tr>";
echo "<tr>";
sortFoods($diets['Maintenance Diet'], 'arsort');
foreach ($diets['Maintenance Diet'] as $category => $items) {
    echo "<td><ul>";
    foreach ($items as $item => $value) {
        if (is_array($value)) {
            // Përdorimi i funksionit sortFoods për renditjen e elementeve
            sortFoods($value, 'asort');
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
echo "<h1>Athlete's Diet </h1>";
echo "<table border='1'>";
echo "<tr><th>Carbs</th><th>Protein</th><th>Fats</th><th>Hydration</th></tr>";
echo "<tr>";
sortFoods($diets['Athlete'],'krsort');
foreach ($diets['Athlete'] as $category => $items) {
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

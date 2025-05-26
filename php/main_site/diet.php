<?php
require 'headers.php';
require '../db.php'; 


function getNutritionPlans($conn, $category) {
    $stmt = $conn->prepare("SELECT title, description, calories, protein, carbs, fats FROM nutrition_plans WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    return $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ILLYRIAN Gym - Diet</title>
    <link rel="stylesheet" href="../../css/style.css">
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
        .diet-section {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>

<header>
    <a href="index.php" class="logo">ILLYRIAN <span>Gym</span></a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <?php echo generateMenu($menu_items, basename($_SERVER['PHP_SELF'])); ?>
    </ul>
    <div class="top-btn">
        <a href="../login.php" class="nav-btn">Log in</a>
    </div>
    <div class="senvichi">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <script src="../../javascj/javascript.js"></script>
</header>

<div class="diet" data-aos="zoom-in">
    <?php
    $categories = [
        'weight_loss' => 'Weight Loss',
        'muscle_gain' => 'Muscle Gain',
        'maintenance' => 'Maintenance'
    ];

    foreach ($categories as $cat_key => $cat_label):
        $plans = getNutritionPlans($conn, $cat_key);
    ?>
        <div class="diet-section">
            <h1><?php echo $cat_label; ?> Plans</h1>
            <?php if ($plans->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Calories</th>
                        <th>Protein (g)</th>
                        <th>Carbs (g)</th>
                        <th>Fats (g)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $plans->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                        <td><?php echo $row['calories']; ?></td>
                        <td><?php echo $row['protein']; ?></td>
                        <td><?php echo $row['carbs']; ?></td>
                        <td><?php echo $row['fats']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No nutrition plans available for this category.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>

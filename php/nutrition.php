<?php 
include 'header.php';
include 'db.php';
include 'sidebar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_plan']) && $_SESSION['role'] === 'admin') {
        $stmt = $conn->prepare("INSERT INTO nutrition_plans (title, description, calories, protein, carbs, fats, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiis", $_POST['title'], $_POST['description'], $_POST['calories'], $_POST['protein'], $_POST['carbs'], $_POST['fats'], $_POST['category']);
        $stmt->execute();
    } elseif (isset($_POST['save_preferences'])) {
        $stmt = $conn->prepare("REPLACE INTO user_nutrition_preferences (user_id, preferred_calories, dietary_restrictions, favorite_meals) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $_SESSION['user_id'], $_POST['preferred_calories'], $_POST['dietary_restrictions'], $_POST['favorite_meals']);
        $stmt->execute();
    } elseif (isset($_POST['delete_plan']) && $_SESSION['role'] === 'admin') {
        $stmt = $conn->prepare("DELETE FROM nutrition_plans WHERE id = ?");
        $stmt->bind_param("i", $_POST['plan_id']);
        $stmt->execute();
    }
}

// Get preferences
$preferences = ['preferred_calories' => '', 'dietary_restrictions' => '', 'favorite_meals' => ''];
if ($_SESSION['role'] === 'client') {
    $stmt = $conn->prepare("SELECT preferred_calories, dietary_restrictions, favorite_meals FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $preferences = $row;
    }

    $minCalories = (int)$preferences['preferred_calories'] - 200;
    $maxCalories = (int)$preferences['preferred_calories'] + 200;

    $query = "SELECT * FROM nutrition_plans WHERE calories BETWEEN ? AND ?";
    $params = [$minCalories, $maxCalories];
    $types = "ii";

    if (!empty($preferences['dietary_restrictions'])) {
        $restrictions = explode(',', $preferences['dietary_restrictions']);
        foreach ($restrictions as $restriction) {
            $restriction = trim($restriction);
            if ($restriction !== '') {
                $query .= " AND description NOT LIKE ?";
                $params[] = '%' . $restriction . '%';
                $types .= "s";
            }
        }
    }

    if (!empty($preferences['favorite_meals'])) {
        $favoriteMeals = explode(',', $preferences['favorite_meals']);
        $favoriteMealsConditions = [];
        foreach ($favoriteMeals as $meal) {
            $meal = trim($meal);
            if ($meal !== '') {
                $favoriteMealsConditions[] = "(title LIKE ? OR description LIKE ?)";
                $params[] = '%' . $meal . '%';
                $params[] = '%' . $meal . '%';
                $types .= "ss";
            }
        }
        if (count($favoriteMealsConditions) > 0) {
            $query .= " AND (" . implode(" OR ", $favoriteMealsConditions) . ")";
        }
    }

    $planStmt = $conn->prepare($query);
    $planStmt->bind_param($types, ...$params);
    $planStmt->execute();
    $plansResult = $planStmt->get_result();
} else {
    $plansResult = $conn->query("SELECT * FROM nutrition_plans");
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Plani Ushqimor - ILLYRIAN GYM</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-green: #45ffca;
            --neon-blue: #33ccff;
            --neon-glow-green: 0 0 5px #45ffca, 0 0 10px rgba(69, 255, 202, 0.5);
            --neon-glow-blue: 0 0 5px #33ccff, 0 0 10px rgba(51, 204, 255, 0.5);
        }

        body {
            background-color: #0a0a0a;
            color: #e0e0e0;
            font-family: 'Rajdhani', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-top: 100px;
            margin-left: 300px;
            padding: 20px;
        }

        h1, h2 {
            font-family: 'Orbitron', sans-serif;
            color: white;
            text-shadow: var(--neon-glow-blue);
        }

        .card, .plan-card {
            background-color: #111;
            border: 1px solid var(--neon-green);
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .plan-card {
            border-color: var(--neon-blue);
        }

        .card:hover, .plan-card:hover {
            box-shadow: var(--neon-glow-green);
        }

        .btn {
            background-color: transparent;
            color: var(--neon-blue);
            border: 1px solid var(--neon-blue);
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            font-family: 'Orbitron', sans-serif;
        }

        .btn:hover {
            color: var(--neon-green);
            border-color: var(--neon-green);
            box-shadow: var(--neon-glow-green);
        }

        input, select, textarea {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 100%;
        }

        .plan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1><i class="fas fa-utensils"></i> Plani Ushqimor</h1>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="card">
                <h2>Shto Plan të Ri Ushqimor</h2>
                <form method="post">
                    <input type="text" name="title" placeholder="Titulli" required>
                    <textarea name="description" placeholder="Përshkrimi" required></textarea>
                    <select name="category" required>
                        <option value="weight_loss">Humbje peshe</option>
                        <option value="muscle_gain">Fitim muskujsh</option>
                        <option value="maintenance">Mbajtje peshe</option>
                    </select>
                    <input type="number" name="calories" placeholder="Kalori" required>
                    <input type="number" name="protein" placeholder="Proteina (g)" required>
                    <input type="number" name="carbs" placeholder="Karbohidrate (g)" required>
                    <input type="number" name="fats" placeholder="Yndyrna (g)" required>
                    <button type="submit" name="add_plan" class="btn">Shto</button>
                </form>
            </div>
        <?php else: ?>
            <div class="card">
                <h2>Preferencat e Mia Ushqimore</h2>
                <form method="post">
                    <input type="number" name="preferred_calories" placeholder="Kaloritë e preferuara" value="<?= $preferences['preferred_calories'] ?>" required>
                    <input type="text" name="dietary_restrictions" placeholder="Kufizime dietike" value="<?= $preferences['dietary_restrictions'] ?>">
                    <input type="text" name="favorite_meals" placeholder="Ushqime të preferuara" value="<?= $preferences['favorite_meals'] ?>">
                    <button type="submit" name="save_preferences" class="btn">Ruaj Preferencat</button>
                </form>
            </div>
        <?php endif; ?>

        <h2>Planet Ushqimore</h2>
        <div class="plan-grid">
            <?php while ($plan = $plansResult->fetch_assoc()): ?>
                <div class="plan-card">
                    <h3><?= htmlspecialchars($plan['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($plan['description'])) ?></p>
                    <p><strong>Kalori:</strong> <?= $plan['calories'] ?> | <strong>Proteina:</strong> <?= $plan['protein'] ?>g | <strong>Karbo:</strong> <?= $plan['carbs'] ?>g | <strong>Yndyrna:</strong> <?= $plan['fats'] ?>g</p>
                    <p><strong>Kategoria:</strong> <?= ucfirst(str_replace('_', ' ', $plan['category'])) ?></p>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <form method="post" onsubmit="return confirm('A jeni i sigurt që doni ta fshini këtë plan?');">
                            <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                            <button type="submit" name="delete_plan" class="btn">Fshij</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

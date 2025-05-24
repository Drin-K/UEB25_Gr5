<?php 
include '../general/header.php';
include '../general/sidebar.php';
include 'data/nutrition_data.php'; 
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Plani Ushqimor - ILLYRIAN GYM</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/nutrition.css">
    <style>
       
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

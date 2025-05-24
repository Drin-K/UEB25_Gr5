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

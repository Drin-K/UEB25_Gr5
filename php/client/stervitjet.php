<?php 
include("../general/header.php");
include("../general/sidebar.php");
include("../db.php");
include("../get_set_data/get_stervitjet.php");
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet e Stërvitjes</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/stervitjet.css">
</head>
<body>
<div class="content">
    <h2>Planet e Mia të Stërvitjes</h2>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <div class="create-plan-form">
        <h3>Krijo Plan të Ri</h3>
        <form method="post" action="../get_set_data/set_stervitjet.php">
            <div class="form-group">
                <input type="text" name="new_title" placeholder="Titulli i Planit" required>
            </div>
            <div class="form-group">
                <textarea name="new_description" rows="4" placeholder="Përshkrimi i Planit"></textarea>
            </div>
            <button type="submit" name="create_plan" class="btn create-btn">Krijo Plan</button>
        </form>
    </div>

    <div class="plan-container">
        <?php if ($plans->num_rows > 0): 
            while ($row = $plans->fetch_assoc()):
                $isSuggested = ($suggestedPlanId == $row['id']);
                $isActive = ($activePlanId == $row['id']);
        ?>
            <div class="plan-card <?= $isActive ? 'active-plan' : ($isSuggested ? 'suggested-plan' : '') ?>">
                <form method="post" action="../get_set_data/set_stervitjet.php" class="desc-form">
                    <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" class="plan-title">
                    <small>🗓️ <?= date("d M Y", strtotime($row['created_at'])) ?></small>
                    <textarea name="description" rows="4"><?= htmlspecialchars($row['description']) ?></textarea>
                    <input type="hidden" name="plan_id" value="<?= $row['id'] ?>">
                    <div class="form-actions">
                        <button type="submit" name="update_plan" class="btn update-btn">Ruaj</button>
                        <button type="submit" name="select_plan" class="btn select-btn">Zgjidh</button>
                        <button type="submit" name="delete_plan" class="btn delete-btn" onclick="return confirm('A jeni i sigurt që doni të fshini këtë plan?')">Fshi</button>
                    </div>
                    
                    <?php if ($isSuggested): ?>
                        <div class="plan-badge suggested-badge">⭐ Më i përdoruri</div>
                    <?php endif; ?>
                    <?php if ($isActive): ?>
                        <div class="plan-badge active-badge">✓ Aktive</div>
                    <?php endif; ?>
                </form>
            </div>
        <?php endwhile; else: ?>
            <p class="no-plans">Nuk keni asnjë plan të stërvitjes. Krijo një plan të ri!</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

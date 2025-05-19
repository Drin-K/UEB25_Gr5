<?php
include("header.php");
include("sidebar.php");
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = (int)$_SESSION['user_id'];

// Merr preferencat e përdoruesit në mënyrë të sigurt
$query = $conn->prepare("SELECT preferred_calories FROM user_nutrition_preferences WHERE user_id = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();
$userPreferences = $result->fetch_assoc();
$preferredCalories = $userPreferences['preferred_calories'] ?? 2000;

// Ngjyra e background nga cookie
$bgPreference = $_COOKIE['bg_preference'] ?? '#ffffff';

// Planet e shikuara nga cookie
$viewedPlans = isset($_COOKIE['viewed_plans']) ? json_decode($_COOKIE['viewed_plans'], true) : [];
if (!is_array($viewedPlans)) {
    $viewedPlans = [];
}

// Funksion për ndryshim të ndriçimit të ngjyrës
function adjustBrightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $steps));
    $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $steps));
    $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $steps));
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

// Merr planet e përshtatura
if ($preferredCalories) {
    $range = $preferredCalories * 0.1;
    $minCal = $preferredCalories - $range;
    $maxCal = $preferredCalories + $range;

    $stmt = $conn->prepare("SELECT * FROM nutrition_plans WHERE calories BETWEEN ? AND ?");
    $stmt->bind_param("ii", $minCal, $maxCal);
} else {
    $stmt = $conn->prepare("SELECT * FROM nutrition_plans");
}
$stmt->execute();
$plans = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Ushqimi - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="../css/nutrition.css">
    <style>
        body {
            background-color: <?= htmlspecialchars($bgPreference) ?>;
            transition: background-color 0.3s ease;
        }
        .plan-card {
            background-color: <?= adjustBrightness($bgPreference, -20) ?>;
            border-left: 5px solid <?= adjustBrightness($bgPreference, -40) ?>;
        }
        .nutri-item {
            background: <?= adjustBrightness($bgPreference, 10) ?>;
        }
    </style>
</head>
<body>
<div class="content">
    <h2><i class="fas fa-utensils"></i> Plani Juaj i Ushqimit</h2>

    <div class="preferences-form">
        <h3><i class="fas fa-sliders-h"></i> Preferencat e Ushqimit</h3>
        <form method="post" action="save_preferences.php">
            <div class="form-group">
                <label>Kalori të preferuara:</label>
                <input type="number" name="calories" value="<?= (int)$preferredCalories ?>" required>
            </div>
            <div class="form-group">
                <label>Ngjyra e Background:</label>
                <input type="color" name="bg_color" value="<?= htmlspecialchars($bgPreference) ?>">
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn">Ruaj</button>
                <button type="submit" name="reset_cookies" class="btn btn-danger">Fshi Cookies</button>
            </div>
        </form>
    </div>

    <h3><i class="fas fa-star"></i> Planet e Ushqimit për Ju</h3>
    <div class="plans-container">
        <?php while ($plan = $plans->fetch_assoc()):
            $planId = (int)$plan['id'];
            if (!in_array($planId, $viewedPlans)) {
                array_unshift($viewedPlans, $planId);
                if (count($viewedPlans) > 5) array_pop($viewedPlans);
                setcookie('viewed_plans', json_encode($viewedPlans), time() + 86400 * 30, "/");
            }
        ?>
        <div class="plan-card">
            <h4><?= htmlspecialchars($plan['title']) ?></h4>
            <p><?= htmlspecialchars($plan['description']) ?></p>
            <div class="nutri-facts">
                <div class="nutri-item"><span><?= (int)$plan['calories'] ?></span><small>Kalori</small></div>
                <div class="nutri-item"><span><?= (int)$plan['protein'] ?>g</span><small>Proteina</small></div>
                <div class="nutri-item"><span><?= (int)$plan['carbs'] ?>g</span><small>Karbohidrate</small></div>
                <div class="nutri-item"><span><?= (int)$plan['fats'] ?>g</span><small>Yndyrna</small></div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <?php if (!empty($viewedPlans)): 
        $placeholders = implode(',', array_fill(0, count($viewedPlans), '?'));
        $types = str_repeat('i', count($viewedPlans));
        $stmtRecent = $conn->prepare("SELECT * FROM nutrition_plans WHERE id IN ($placeholders)");
        $stmtRecent->bind_param($types, ...$viewedPlans);
        $stmtRecent->execute();
        $recentPlans = $stmtRecent->get_result();
    ?>
    <div class="recently-viewed">
        <h3><i class="fas fa-history"></i> Planet e Shikuara Së Fundi</h3>
        <div class="recent-plans">
            <?php while ($plan = $recentPlans->fetch_assoc()): ?>
            <div class="plan-card">
                <h4><?= htmlspecialchars($plan['title']) ?></h4>
                <p><?= htmlspecialchars(mb_substr($plan['description'], 0, 100)) ?>...</p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>

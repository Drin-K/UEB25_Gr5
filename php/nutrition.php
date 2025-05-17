<?php
include("header.php");
include("sidebar.php");
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getUserNutritionPreferences($userId, $conn) {
    $stmt = $conn->prepare("SELECT * FROM user_nutrition_preferences WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getNutritionPlans($calories, $conn) {
    $query = "SELECT * FROM nutrition_plans";
    if ($calories) {
        $query .= " WHERE calories BETWEEN ? AND ?";
        $range = $calories * 0.9;
        $params = [$calories - $range, $calories + $range];
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", ...$params);
    } else {
        $stmt = $conn->prepare($query);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Funksioni për rregullimin e ngjyrës
function adjustBrightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}


$userPreferences = getUserNutritionPreferences($_SESSION['user_id'], $conn);
$preferredCalories = $userPreferences['preferred_calories'] ?? 2000;
$bgPreference = $_COOKIE['bg_preference'] ?? '#ffffff';
$viewedPlans = isset($_COOKIE['viewed_plans']) ? json_decode($_COOKIE['viewed_plans'], true) : [];
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ushqimi - ILLYRIAN GYM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="../css/nutrition.css">
  <style>
        body {
            background-color: <?= $bgPreference ?>;
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
                    <label><i class="fas fa-fire"></i> Kalori të preferuara:</label>
                    <input type="number" name="calories" value="<?= $preferredCalories ?>">
                </div>
             <div class="form-group">
                    <label><i class="fas fa-palette"></i> Ngjyra e Background:</label>
                    <input type="color" name="bg_color" value="<?= $bgPreference ?>">
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn"><i class="fas fa-save"></i> Ruaj</button>
                    <button type="submit" name="reset_cookies" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Fshi Cookies
                    </button>
                </div>
            </form>
        </div>
        
        <h3><i class="fas fa-star"></i> Planet e Ushqimit për Ju</h3>
        <div class="plans-container">
            <?php
            $plans = getNutritionPlans($preferredCalories, $conn);
            while ($plan = $plans->fetch_assoc()):
                if (!in_array($plan['id'], $viewedPlans)) {
                    array_unshift($viewedPlans, $plan['id']);
                    if (count($viewedPlans) > 5) array_pop($viewedPlans);
                    if (!headers_sent()) {
                        setcookie('viewed_plans', json_encode($viewedPlans), time() + 86400 * 30, "/");
                    }
                }
            ?>
            <div class="plan-card">
                <h4><?= htmlspecialchars($plan['title']) ?></h4>
                <p><?= htmlspecialchars($plan['description']) ?></p>
                <div class="nutri-facts">
                    <div class="nutri-item">
                        <span><?= $plan['calories'] ?></span>
                        <small>Kalori</small>
                    </div>
                    <div class="nutri-item">
                        <span><?= $plan['protein'] ?>g</span>
                        <small>Proteina</small>
                    </div>
                    <div class="nutri-item">
                        <span><?= $plan['carbs'] ?>g</span>
                        <small>Karbohidrate</small>
                    </div>
                    <div class="nutri-item">
                        <span><?= $plan['fats'] ?>g</span>
                        <small>Yndyrna</small>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <?php if (!empty($viewedPlans)): ?>
        <div class="recently-viewed">
            <h3><i class="fas fa-history"></i> Planet e Shikuara Së Fundi</h3>
            <div class="recent-plans">
                <?php
                $placeholders = implode(',', array_fill(0, count($viewedPlans), '?'));
                $stmt = $conn->prepare("SELECT * FROM nutrition_plans WHERE id IN ($placeholders)");
                $stmt->bind_param(str_repeat('i', count($viewedPlans)), ...$viewedPlans);
                $stmt->execute();
                $recentPlans = $stmt->get_result();
                
                while ($plan = $recentPlans->fetch_assoc()):
                ?>
                <div class="plan-card">
                    <h4><?= htmlspecialchars($plan['title']) ?></h4>
                    <p><?= htmlspecialchars(substr($plan['description'], 0, 100)) ?>...</p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

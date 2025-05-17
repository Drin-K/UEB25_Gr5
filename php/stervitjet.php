<?php
include("header.php");
include("sidebar.php");
include("db.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$role = $_SESSION['role'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? 0;

$successMessage = "";
$suggestedPlanId = null;

// Get most used plan for suggestion
$stmt = $conn->prepare("SELECT id FROM workout_plans WHERE user_id = ? ORDER BY usage_count DESC LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $suggestedPlan = $result->fetch_assoc();
    $suggestedPlanId = $suggestedPlan['id'];
}
$stmt->close();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update plan
    if (isset($_POST['update_plan'])) {
        $planId = $_POST['plan_id'];
        $newDescription = $_POST['description'];
        $newTitle = $_POST['title'];

        $stmt = $conn->prepare("UPDATE workout_plans SET description = ?, title = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $newDescription, $newTitle, $planId, $userId);
        if ($stmt->execute()) {
            $successMessage = "✅ Plani u përditësua me sukses!";
        } else {
            $successMessage = "❌ Ndodhi një gabim gjatë përditësimit!";
        }
        $stmt->close();
    }
    // Create new plan
    elseif (isset($_POST['create_plan'])) {
        $title = $_POST['new_title'];
        $description = $_POST['new_description'];

        if (!empty($title)) {
            $stmt = $conn->prepare("INSERT INTO workout_plans (user_id, title, description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $title, $description);
            if ($stmt->execute()) {
                $successMessage = "✅ Plani i ri u krijua me sukses!";
            } else {
                $successMessage = "❌ Ndodhi një gabim gjatë krijimit të planit!";
            }
            $stmt->close();
        } else {
            $successMessage = "❌ Titulli nuk mund të jetë bosh!";
        }
    }
    // Delete plan
    elseif (isset($_POST['delete_plan'])) {
        $planId = $_POST['plan_id'];

        $stmt = $conn->prepare("DELETE FROM workout_plans WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $planId, $userId);
        if ($stmt->execute()) {
            $successMessage = "✅ Plani u fshi me sukses!";
        } else {
            $successMessage = "❌ Ndodhi një gabim gjatë fshirjes së planit!";
        }
        $stmt->close();
    }
    // Select plan
    elseif (isset($_POST['select_plan'])) {
        $planId = $_POST['plan_id'];

        // Update usage count
        $stmt = $conn->prepare("UPDATE workout_plans SET usage_count = usage_count + 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $planId, $userId);
        $stmt->execute();
        $stmt->close();
        
        // Set cookie that expires in 30 days
        setcookie('last_used_plan', $planId, time() + (30 * 24 * 60 * 60), "/");
        $successMessage = "✅ Plani u zgjodh si aktiv!";
    }
}

// Check for last used plan from cookie
$lastUsedPlanId = $_COOKIE['last_used_plan'] ?? null;

// Get all user's plans
$stmt = $conn->prepare("SELECT * FROM workout_plans WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$plans = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet e Stërvitjes</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/stervitjet.css">
</head>
<body>
<div class="content">
    <h2>Planet e Mia të Stërvitjes</h2>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <!-- Create New Plan Form -->
    <div class="create-plan-form">
        <h3>Krijo Plan të Ri</h3>
        <form method="post">
            <div class="form-group">
                <input type="text" name="new_title" placeholder="Titulli i Planit" required>
            </div>
            <div class="form-group">
                <textarea name="new_description" rows="4" placeholder="Përshkrimi i Planit"></textarea>
            </div>
            <button type="submit" name="create_plan" class="btn create-btn">Krijo Plan</button>
        </form>
    </div>

    <!-- User's Plans -->
    <div class="plan-container">
        <?php 
        if ($plans->num_rows > 0): 
            while ($row = $plans->fetch_assoc()): 
                $isSuggested = ($suggestedPlanId == $row['id']);
                $isLastUsed = ($lastUsedPlanId == $row['id']);
                $cardClass = '';
                if ($isSuggested) $cardClass = 'suggested-plan';
                if ($isLastUsed) $cardClass = 'active-plan';
        ?>
                <div class="plan-card <?= $cardClass ?>">
                    <form method="post" class="desc-form">
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
                        <?php if ($isLastUsed): ?>
                            <div class="plan-badge active-badge">✓ Aktive</div>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-plans">Nuk keni asnjë plan të stërvitjes. Krijo një plan të ri!</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
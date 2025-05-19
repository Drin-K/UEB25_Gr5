<?php
include("header.php");
include("sidebar.php");
include("db.php");

// o Kthimi përmes referencës

// Funksioni kthen një referencë të array $reports
// Për shkak se është me &, ndryshimet jashtë do prekin array-n origjinal
function &getReports(mysqli &$conn): array {
    // Ky përdor variablën globale $conn brenda funksionit, edhe pse ajo tashmë është në parametër.
    global $conn;
    $reports = [];

    $query = "
        SELECT 
            u.id AS user_id,
            u.name,
            u.email,
            u.created_at,
            (SELECT COUNT(*) FROM subscriptions s WHERE s.user_id = u.id) AS total_subscriptions,
            (SELECT COUNT(*) FROM workout_plans wp WHERE wp.user_id = u.id) AS total_workouts,
            (SELECT COUNT(*) FROM payments p WHERE p.user_id = u.id) AS total_payments,
            (SELECT IFNULL(SUM(amount), 0) FROM payments p WHERE p.user_id = u.id) AS total_paid,
            (SELECT GROUP_CONCAT(DISTINCT np.category SEPARATOR ', ') 
             FROM user_nutrition_preferences unp 
             JOIN nutrition_plans np ON np.category IS NOT NULL 
             WHERE unp.user_id = u.id) AS nutrition_categories,
            (SELECT preferred_calories FROM user_nutrition_preferences WHERE user_id = u.id) AS preferred_calories
        FROM users u
        WHERE u.role = 'client'
    ";

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }

    return $reports; // <- Kthim përmes referencës
}

// o Përdorimi i funksioneve me referencë
// o Përcjellja përmes referencës
// Parametri $conn kalohet me referencë në këtë funksion

function getCalorieDistribution(mysqli $conn): array {
    $query = "
        SELECT 
            np.category,
            AVG(np.calories) AS avg_calories,
            COUNT(*) AS plan_count
        FROM nutrition_plans np
        GROUP BY np.category
    ";
    
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

// o Vendosja e referencave në mes të anëtarëve të vargut
$allReports = &getReports($conn); // -> variabla $allReports është referencë ndaj array-t të kthyer
$calorieData = getCalorieDistribution($conn);
// o Largimi i referencës
unset($conn); // -> Heqja e referencës ndaj objektit të lidhjes me DB
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Raportet e Përdoruesve</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #111;
            color: #fff;
            box-shadow: 0 0 12px rgba(46, 255, 126, 0.2);
            font-family: 'Segoe UI', sans-serif;
        }
        .report-table th, .report-table td {
            border: 1px solid #2eff7e;
            padding: 12px;
            text-align: center;
        }
        .report-table th {
            background-color: #000;
            color: #2eff7e;
            text-shadow: 0 0 5px #2eff7e;
        }
        .report-header {
            text-align: center;
            font-size: 24px;
            color: #2eff7e;
            text-shadow: 0 0 8px #2eff7e;
            margin-top: 20px;
        }
        .chart-container {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        .chart-box {
            width: 45%;
            min-width: 300px;
            background-color: #111;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(46, 255, 126, 0.2);
            margin-bottom: 20px;
        }
        .chart-title {
            color: #2eff7e;
            text-align: center;
            margin-bottom: 15px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="content">
    <h2 class="report-header">Raportet e Përdoruesve</h2>

    <div class="chart-container">
        <div class="chart-box">
            <h3 class="chart-title">Shpërndarja e Kalorive sipas Kategorive</h3>
            <canvas id="calorieChart"></canvas>
        </div>
        
        <div class="chart-box">
            <h3 class="chart-title">Kaloritë e Preferuara nga Përdoruesit</h3>
            <canvas id="userCalorieChart"></canvas>
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Email</th>
                <th>Regjistruar më</th>
                <th>Abonime</th>
                <th>Planet e Stërvitjes</th>
                <th>Pagesa</th>
                <th>Total i Paguar (€)</th>
                <th>Preferenca Nutricionale</th>
                <th>Kaloritë e Preferuara</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allReports as &$report): ?>
                <tr>
                    <td><?= $report['user_id'] ?></td>
                    <td><?= htmlspecialchars($report['name']) ?></td>
                    <td><?= htmlspecialchars($report['email']) ?></td>
                    <td><?= $report['created_at'] ?></td>
                    <td><?= $report['total_subscriptions'] ?></td>
                    <td><?= $report['total_workouts'] ?></td>
                    <td><?= $report['total_payments'] ?></td>
                    <td>€<?= number_format($report['total_paid'], 2) ?></td>
                    <td><?= $report['nutrition_categories'] ?: 'Asnjë' ?></td>
                    <td><?= $report['preferred_calories'] ?: 'N/A' ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($report); ?>
        </tbody>
    </table>
</div>

<script>
    // Chart për shpërndarjen e kalorive sipas kategorive
    const calorieCtx = document.getElementById('calorieChart').getContext('2d');
    const calorieChart = new Chart(calorieCtx, {
        type: 'pie',
        data: {
            labels: [<?php echo implode(',', array_map(function($item) { 
                return "'" . ucfirst(str_replace('_', ' ', $item['category'])) . "'"; 
            }, $calorieData)); ?>],
            datasets: [{
                data: [<?php echo implode(',', array_column($calorieData, 'avg_calories')); ?>],
                backgroundColor: [
                    'rgba(46, 255, 126, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)'
                ],
                borderColor: [
                    'rgba(46, 255, 126, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} kalori (mesatare)`;
                        }
                    }
                }
            }
        }
    });

    // Chart për kaloritë e preferuara nga përdoruesit
    const userCalorieCtx = document.getElementById('userCalorieChart').getContext('2d');
    const userCalorieChart = new Chart(userCalorieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Përdorues me preferenca', 'Përdorues pa preferenca'],
            datasets: [{
                data: [
                    <?= count(array_filter($allReports, fn($r) => !empty($r['preferred_calories']))); ?>,
                    <?= count(array_filter($allReports, fn($r) => empty($r['preferred_calories']))); ?>
                ],
                backgroundColor: [
                    'rgba(46, 255, 126, 0.7)',
                    'rgba(255, 255, 255, 0.3)'
                ],
                borderColor: [
                    'rgba(46, 255, 126, 1)',
                    'rgba(255, 255, 255, 0.5)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} përdorues`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
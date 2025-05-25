<?php
include("../general/header.php");
include("../general/sidebar.php");
include("../get_set_data/get_reports.php");
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Raportet e Përdoruesve</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
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
            <h3 class="chart-title">Kaloritë e Preferuara nga Përdoresit</h3>
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
                <th>Stërvitje</th>
                <th>Pagesa</th>
                <th>Anëtarësimi i fundit</th>
                <th>Kalori të preferuara</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allReports as &$report): ?>
                <tr>
                    <td><?= $report['user_id'] ?></td>
                    <td><?= htmlspecialchars($report['name']) ?></td>
                    <td><?= htmlspecialchars($report['email']) ?></td>
                    <td><?= htmlspecialchars($report['created_at']) ?></td>
                    <td><?= (int)$report['total_workouts'] ?></td>
                    <td><?= (int)$report['total_payments'] ?></td>
                    <td><?= $report['last_membership'] ?? '—' ?></td>
                    <td><?= $report['preferred_calories'] ?? '—' ?></td>
                </tr>
            <?php endforeach; ?>
            <?php unset($report); ?>
        </tbody>
    </table>
</div>

<script>
    const calorieLabels = <?= json_encode(array_map(fn($i) => ucfirst(str_replace('_', ' ', $i['category'])), $calorieData)) ?>;
    const calorieValues = <?= json_encode(array_column($calorieData, 'avg_calories')) ?>;
    const withPrefs = <?= count(array_filter($allReports, fn($r) => !empty($r['preferred_calories']))) ?>;
    const withoutPrefs = <?= count(array_filter($allReports, fn($r) => empty($r['preferred_calories']))) ?>;

    const makeChart = (id, type, labels, data, bg, border, labelText) => {
        new Chart(document.getElementById(id), {
            type,
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: bg,
                    borderColor: border,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#fff', font: { size: 12 } } },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} ${labelText}`
                        }
                    }
                }
            }
        });
    };

    makeChart('calorieChart', 'pie', calorieLabels, calorieValues,
        ['rgba(46,255,126,0.7)', 'rgba(255,99,132,0.7)', 'rgba(54,162,235,0.7)'],
        ['rgba(46,255,126,1)', 'rgba(255,99,132,1)', 'rgba(54,162,235,1)'],
        'kalori (mesatare)'
    );

    makeChart('userCalorieChart', 'doughnut',
        ['Përdorues me preferenca', 'Përdorues pa preferenca'],
        [withPrefs, withoutPrefs],
        ['rgba(46,255,126,0.7)', 'rgba(255,255,255,0.3)'],
        ['rgba(46,255,126,1)', 'rgba(255,255,255,0.5)'],
        'përdorues'
    );
</script>

</body>
</html>

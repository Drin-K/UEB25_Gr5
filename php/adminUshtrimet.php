<?php

$allWorkouts = ['Back', 'Bicep', 'Tricep', 'Leg', 'Shoulder'];
$counts = [];
foreach ($allWorkouts as $w) {
    $cookieName = "count_$w";
    $counts[$w] = isset($_COOKIE[$cookieName]) ? (int)$_COOKIE[$cookieName] : 0;
}

// 3. Sort the workouts by count descending
arsort($counts);
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Renditja e Workouts</title>
  <style>
    body {
      margin: 0;
      background: #0b0d10;
      color: #cfd8dc;
      font-family: sans-serif;
    }
    .container {
      margin-left: 250px;   /* clear your sidebar */
      padding: 2rem;
    }
    h2 {
      color: #00edc1;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #0d0f12;
      border: 1px solid #1f262a;
      border-radius: 8px;
      overflow: hidden;
    }
    thead {
      background: #111417;
    }
    th, td {
      padding: 0.75rem 1rem;
      text-align: left;
      font-size: 0.9rem;
    }
    thead th {
      color: #00edc1;
      text-transform: uppercase;
      font-size: 0.85rem;
    }
    tbody tr {
      border-bottom: 1px solid #1f262a;
      transition: background 0.2s;
    }
    tbody tr:last-child {
      border-bottom: none;
    }
    tbody tr:hover {
      background: rgba(0,237,193,0.1);
    }
    .rank {
      display: inline-block;
      min-width: 24px;
      text-align: center;
      border-radius: 50%;
      padding: 0.25rem;
      font-weight: bold;
      color: #0b0f12;
      background: #00edc1;
      margin-right: 0.5rem;
    }
    .most-used {
      background: #ffbe00;
    }
    .least-used {
      background: #808080;
      color: #fff;
    }
    @media (max-width: 600px) {
      .container {
        margin-left: 0;
      }
      th, td {
        font-size: 0.8rem;
        padding: 0.5rem;
      }
    }
  </style>
</head>
<body>
  <?php include("header.php"); include("sidebar.php"); ?>

  <div class="container">
    <h2>Renditja e Workouts (24 h)</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Workout</th>
          <th>Përdorime</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $rank = 1;
          $total = count($counts);
          foreach ($counts as $workout => $cnt):
            // determine classes for most/least used
            $classes = ['rank'];
            if ($rank === 1)      $classes[] = 'most-used';
            if ($rank === $total) $classes[] = 'least-used';
        ?>
        <tr>
          <td><span class="<?= implode(' ', $classes) ?>"><?= $rank ?></span></td>
          <td><?= htmlspecialchars($workout) ?></td>
          <td><?= $cnt ?></td>
        </tr>
        <?php
            $rank++;
          endforeach;
        ?>
      </tbody>
    </table>
  </div>

  <?php include("footer.php"); ?>
</body>
</html>

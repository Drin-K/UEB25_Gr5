<?php
$counts = require_once("logic/workoutCountsLogic.php");
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Renditja e Workouts</title>
  <link rel="stylesheet" href="../../css/subscription.css">
</head>
<body>
  <?php include("../general/header.php"); include("../general/sidebar.php"); ?>

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

  <?php include("../general/footer.php"); ?>
</body>
</html>

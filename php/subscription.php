<?php
include("header.php");
include("sidebar.php");
require_once "db.php";
include("../php/get_set_data/get_subscriptionANDpaymentsUpdate.php")

?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Menaxho Subscription</title>
  <link rel="stylesheet" href="../css/subscription.css">
</head>
<body>
  <div class="membership-container">
    <h2>Menaxhimi i subscriptions</h2>
    <div class="plan-columns">

      <?php foreach ($plans as $plan_id => $plan_name): ?>
        <div class="plan-column">
          <h3><?= htmlspecialchars($plan_name) ?></h3>
          <table>
            <thead>
              <tr>
                <th>Përdoruesi</th>
                <th>Fillon</th>
                <th>Skadon</th>
                <th>Statusi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (! empty($by_plan[$plan_id])): ?>
                <?php foreach ($by_plan[$plan_id] as $sub): ?>
                  <tr>
                    <td><?= htmlspecialchars($sub['username']) ?></td>
                    <td><?= htmlspecialchars($sub['start_date']) ?></td>
                    <td><?= htmlspecialchars($sub['end_date']) ?></td>
                    <td>
                      <span class="status <?= $sub['status'] === 'active' ? 'active' : 'expired' ?>">
                        <?= htmlspecialchars($sub['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" style="text-align:center;">
                    Nuk ka përdorues në <?= htmlspecialchars($plan_name) ?>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
<?php include("footer.php"); ?>
</body>
</html>

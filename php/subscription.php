<?php
include("header.php");
include("sidebar.php");
require_once "db.php";

// --- STEP 1: EXPIRE OLD PAYMENTS & NOTIFY USERS ----------------------
// Find any payments still marked 'active' whose 30‑day window has passed
$check_sql = "
  SELECT p.id            AS payment_id,
         u.name          AS username,
         u.email         AS email,
         p.payment_date  AS start_date
  FROM payments p
  JOIN users u ON p.user_id = u.id
  WHERE p.status = 'active'
    AND DATE_ADD(p.payment_date, INTERVAL 30 DAY) < CURDATE()
";
$res = mysqli_query($conn, $check_sql);

if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $pid       = (int) $row['payment_id'];
        $name      = filter_var($row['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email     = filter_var($row['email'],    FILTER_SANITIZE_EMAIL);
        $start     = filter_var($row['start_date'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $end       = date('Y-m-d', strtotime($start . ' +30 days'));

        // Mark expired
        $upd = "UPDATE payments SET status = 'expired' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $upd);
        mysqli_stmt_bind_param($stmt, "i", $pid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Send email
        $subject = "Abonimi juaj ka skaduar";
        $message = "Përshëndetje $name,\n\n"
                 . "Abonimi juaj ka përfunduar më $end.\n"
                 . "Ju lutemi rinovoni për të vazhduar shërbimet tona.\n\n"
                 . "Faleminderit,\nIllyrian Gym";
        $headers = "From: Illyrian Gym <youremail@gmail.com>\r\n"
                 . "Reply-To: youremail@gmail.com\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($email, $subject, $message, $headers);
    }
}

// --- STEP 2: PULL ALL DATA FOR DISPLAY -------------------------------
// 2.a) fetch all membership names, so we can render one column each
$plans       = [];
$plan_query  = "SELECT id, name FROM memberships ORDER BY name";
$plan_res    = mysqli_query($conn, $plan_query);
while ($p = mysqli_fetch_assoc($plan_res)) {
    $plans[$p['id']] = $p['name'];
}

// 2.b) fetch all payments + user + membership
$data_sql = "
  SELECT
    p.id,
    p.user_id,
    u.name                              AS username,
    p.payment_date                      AS start_date,
    DATE_ADD(p.payment_date, INTERVAL 30 DAY) AS end_date,
    p.status,
    p.id_membership                     AS membership_id
  FROM payments p
  JOIN users u ON p.user_id = u.id
  ORDER BY p.payment_date DESC
";
$data_res = mysqli_query($conn, $data_sql);

// group rows by membership_id
$by_plan = [];
while ($r = mysqli_fetch_assoc($data_res)) {
    $by_plan[ $r['membership_id'] ][] = $r;
}

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


<?php
include("header.php");
include("sidebar.php");
require_once "db.php";

// --- HAPI 1: Kontrollo dhe përditëso statusin e skaduar ---
// Çka bën ky query?
// Ky query:
//Merr të gjitha abonimet (subscriptions) që janë:
// me status active
// por kanë end_date më të vogël se data e sotme (CURDATE()).
// ➤ Kjo do të thotë: "Ky abonim duhet të jetë 'expired', por ende është 'active'".
// Bashkon (join) tabelën users për të marrë emrin (name) dhe emailin (email) e përdoruesit.


// 1) Find all active subscriptions that have passed their end date
$check_expired_sql = "
  SELECT s.id           AS subscription_id,
         u.name         AS username,
         u.email        AS email,
         s.end_date     AS end_date
  FROM subscriptions s
  JOIN users u ON s.user_id = u.id
  WHERE s.status  = 'active'
    AND s.end_date < CURDATE()
";

$expired_result = mysqli_query($conn, $check_expired_sql);

if ($expired_result && mysqli_num_rows($expired_result) > 0) {
    while ($row = mysqli_fetch_assoc($expired_result)) {
        // 2) Sanitize the values
        $subscription_id = (int) $row['subscription_id'];
        $name            = filter_var($row['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email           = filter_var($row['email'],    FILTER_SANITIZE_EMAIL);
        $end_date        = filter_var($row['end_date'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // 3) Mark subscription as expired
        $update_sql = "UPDATE subscriptions SET status = 'expired' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "i", $subscription_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 4) Prepare email
        $subject  = "Abonimi juaj ka skaduar";
        $message  = "Përshëndetje $name,\n\n";
        $message .= "Abonimi juaj ka përfunduar më $end_date.\n";
        $message .= "Ju lutemi rinovoni për të vazhduar shërbimet tona.\n\n";
        $message .= "Faleminderit,\nIllyrian Gym";

        // 5) Set headers
        $headers  = "From: Illyrian Gym <youremail@gmail.com>\r\n";
        $headers .= "Reply-To: youremail@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // 6) Send
        mail($email, $subject, $message, $headers);
    }
}


// --- HAPI 2: Merr të dhënat për tabelat ---
$sql = "
  SELECT 
    m.name       AS plan,
    u.id         AS user_id,
    u.name       AS username,
    s.start_date,
    s.end_date,
    s.status
  FROM subscriptions s
  JOIN users       u ON s.user_id       = u.id
  JOIN memberships m ON s.membership_id = m.id
  ORDER BY m.name, s.start_date DESC
";

$result = mysqli_query($conn, $sql); 

$basic_members   = [];
$pro_members     = [];
$premium_members = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['plan'] === 'Basic') {
            $basic_members[] = $row;
        } elseif ($row['plan'] === 'Pro') {
            $pro_members[] = $row;
        } elseif ($row['plan'] === 'Premium') {
            $premium_members[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Menaxho Subscriptions</title>
  <link rel="stylesheet" href="../css/subscription.css">
</head>
<body>

  <div class="membership-container">
    <h2>Menaxhimi i subscriptions</h2>
    <div class="plan-columns">
      
      <!-- BASIC -->
      <div class="plan-column">
        <h3>Basic</h3>
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
            <?php if (!empty($basic_members)): ?>
              <?php foreach($basic_members as $m): ?>
                <tr>
                  <td><?= htmlspecialchars($m['username']) ?></td>
                  <td><?= htmlspecialchars($m['start_date']) ?></td>
                  <td><?= htmlspecialchars($m['end_date']) ?></td>
                  <td>
                    <span class="status <?= $m['status']==='active' ? 'active' : 'expired' ?>">
                      <?= htmlspecialchars($m['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center;">Nuk ka përdorues në Basic</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- PRO -->
      <div class="plan-column">
        <h3>Pro</h3>
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
            <?php if (!empty($pro_members)): ?>
              <?php foreach($pro_members as $m): ?>
                <tr>
                  <td><?= htmlspecialchars($m['username']) ?></td>
                  <td><?= htmlspecialchars($m['start_date']) ?></td>
                  <td><?= htmlspecialchars($m['end_date']) ?></td>
                  <td>
                    <span class="status <?= $m['status']==='active' ? 'active' : 'expired' ?>">
                      <?= htmlspecialchars($m['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center;">Nuk ka përdorues në Pro</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- PREMIUM -->
      <div class="plan-column">
        <h3>Premium</h3>
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
            <?php if (!empty($premium_members)): ?>
              <?php foreach($premium_members as $m): ?>
                <tr>
                  <td><?= htmlspecialchars($m['username']) ?></td>
                  <td><?= htmlspecialchars($m['start_date']) ?></td>
                  <td><?= htmlspecialchars($m['end_date']) ?></td>
                  <td>
                    <span class="status <?= $m['status']==='active' ? 'active' : 'expired' ?>">
                      <?= htmlspecialchars($m['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center;">Nuk ka përdorues në Premium</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

<?php include("footer.php"); ?>
</body>
</html>

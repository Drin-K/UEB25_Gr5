<?php
require_once "../db.php";
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

        
        $upd = "UPDATE payments SET status = 'expired' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $upd);
        mysqli_stmt_bind_param($stmt, "i", $pid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

     
        $subject = "Abonimi juaj ka skaduar";
        $message = "Përshëndetje $name,\n\n"
                 . "Abonimi juaj ka përfunduar më $end.\n"
                 . "Ju lutemi rinovoni për të vazhduar shërbimet tona.\n\n"
                 . "Faleminderit,\nIllyrian Gym";
        $headers = "From: Illyrian Gym <drinkurti26@gmail.com>\r\n"
                 . "Reply-To: drinkurti26@gmail.com\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($email, $subject, $message, $headers);
    }
}

$plans       = [];
$plan_query  = "SELECT id, name FROM memberships ORDER BY name";
$plan_res    = mysqli_query($conn, $plan_query);
while ($p = mysqli_fetch_assoc($plan_res)) {
    $plans[$p['id']] = $p['name'];
}


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

$by_plan = [];
while ($r = mysqli_fetch_assoc($data_res)) {
    $by_plan[ $r['membership_id'] ][] = $r;
}

?>
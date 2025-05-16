<?php
include("header.php");
include("sidebar.php");

$user_id = $_SESSION['user_id'];
require_once "db.php";

$sql_active = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
        FROM subscriptions s
        JOIN memberships m ON s.membership_id = m.id
        WHERE s.user_id = ? AND s.status = 'active'
        ORDER BY s.end_date DESC
        LIMIT 1";

$stmt = $conn->prepare($sql_active);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$active_membership = $result->fetch_assoc();
$stmt->close();

$sql_history = "SELECT m.name, m.price, s.start_date, s.end_date, s.status
        FROM subscriptions s
        JOIN memberships m ON s.membership_id = m.id
        WHERE s.user_id = ?
        ORDER BY s.start_date DESC";

$stmt = $conn->prepare($sql_history);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_history = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anëtarësimi</title>
    <link rel="stylesheet" href="../css/anetaresimet.css">
</head>
<body>
   <div class="membership-container">
    <h2>Anëtarësimi aktual</h2>
    <div id="current-membership">Loading...</div>
      
    <h2>Historiku i anëtarësimeve</h2>
    <table>
        <thead>
            <tr>
                <th>Emri</th>
                <th>Çmimi</th>
                <th>Fillimi</th>
                <th>Skadimi</th>
                <th>Statusi</th>
            </tr>
        </thead>
        <tbody id="history-body">
            <tr><td colspan="5">Duke u ngarkuar...</td></tr>
        </tbody>
    </table>
<br>
  <h2>Thënie motivuese</h2>
<div id="motivation" style="color:white;">
</div>
</div>


<script>// Anëtarësimi aktual
fetch('get_membership.php')
  .then(res => {
    if (!res.ok) throw new Error('Gabim rrjeti në anëtarësim aktual');
    return res.json();
  })
  .then(data => {
    const div = document.getElementById('current-membership');
    if (data) {
      div.innerHTML = `
        <p><strong>Emri:</strong> ${data.name}</p>
        <p><strong>Çmimi:</strong> €${data.price}</p>
        <p><strong>Fillon më:</strong> ${data.start_date}</p>
        <p><strong>Skadon më:</strong> ${data.end_date}</p>
        <p><strong>Statusi:</strong> <span class="status-active">${data.status}</span></p>
      `;
    } else {
      div.innerHTML = '<p class="no-membership">Nuk keni asnjë anëtarësim aktiv.</p>';
    }
  })
  .catch(err => {
    document.getElementById('current-membership').textContent = 'Gabim gjatë ngarkimit të anëtarësimit.';
    console.error(err);
  });

// Historiku
fetch('get_history.php')
  .then(res => {
    if (!res.ok) throw new Error('Gabim rrjeti në historikun e anëtarësimeve');
    return res.json();
  })
  .then(data => {
    const tbody = document.getElementById('history-body');
    tbody.innerHTML = '';
    data.forEach(row => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${row.name}</td>
        <td>€${row.price}</td>
        <td>${row.start_date}</td>
        <td>${row.end_date}</td>
        <td class="status-${row.status.toLowerCase()}">${row.status}</td>
      `;
      tbody.appendChild(tr);
    });
  })
  .catch(err => {
    const tbody = document.getElementById('history-body');
    tbody.innerHTML = '<tr><td colspan="5">Gabim gjatë ngarkimit të historikut.</td></tr>';
    console.error(err);
  });

// Motivim
fetch('api_motivation.php')
  .then(res => {
    if (!res.ok) throw new Error('Gabim rrjeti në motivim');
    return res.json();
  })
  .then(data => {
    document.getElementById('motivation').innerHTML = `
      <blockquote>"${data.quote}" — ${data.author}</blockquote>
    `;
  })
  .catch(err => {
    document.getElementById('motivation').textContent = 'Gabim gjatë ngarkimit të motivimit.';
    console.error(err);
  });


</script>

</body>
</html>
<?php
include("footer.php");
?>
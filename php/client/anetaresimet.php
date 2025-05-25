<?php

include("../general/header.php");
include("../general/sidebar.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Anëtarësimet</title>
    <link rel="stylesheet" href="../../css/anetaresimet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="membership-container">
        <h2>Anëtarësimi aktual</h2>
        <div id="current-membership">Duke u ngarkuar...</div>

        <h2>Historiku i anëtarësimeve</h2>
        <table>
            <thead>
                <tr>
                    <th>Emri</th>
                    <th>Çmimi</th>
                    <th>Data e pagesës</th>
                    <th>Statusi</th>
                </tr>
            </thead>
            <tbody id="history-body">
                <tr><td colspan="5">Duke u ngarkuar...</td></tr>
            </tbody>
        </table>
        <br>
        <h2>Thënie motivuese</h2>
        <div id="motivation" style="color:white;">Duke u ngarkuar...</div>
    </div>

<script>
$(document).ready(function(){

 
    $.ajax({
        url: '../get_set_data/get_membership.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data) {
                $('#current-membership').html(`
                    <p><strong>Emri:</strong> ${data.name}</p>
                    <p><strong>Çmimi:</strong> €${data.price}</p>
                    <p><strong>Data e pagesës:</strong> ${data.payment_date}</p>
                    <p><strong>Statusi:</strong> <span class="status-active">${data.status}</span></p>
                `);
            } else {
                $('#current-membership').html('<p class="no-membership">Nuk keni asnjë anëtarësim aktiv.</p>');
            }
        },
        error: function() {
            $('#current-membership').text('Gabim gjatë ngarkimit të anëtarësimit.');
        }
    });

    $.ajax({
        url: '../get_set_data/get_history.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let html = '';
            data.forEach(function(row) {
                html += `
                    <tr>
                        <td>${row.name}</td>
                        <td>€${row.price}</td>
                        <td>${row.payment_date}</td>
                        <td class="status-${row.status.toLowerCase()}">${row.status}</td>
                    </tr>
                `;
            });
            $('#history-body').html(html);
        },
        error: function() {
            $('#history-body').html('<tr><td colspan="5">Gabim gjatë ngarkimit të historikut.</td></tr>');
        }
    });

    $.ajax({
        url: '../get_set_data/api_motivation.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#motivation').html(`<blockquote>"${data.quote}" — ${data.author}</blockquote>`);
        },
        error: function() {
            $('#motivation').text('Gabim gjatë ngarkimit të motivimit.');
        }
    });

});
</script>

</body>
</html>

<?php include("../general/footer.php"); ?>

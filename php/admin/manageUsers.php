<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
} elseif ($_SESSION['usertype'] == 'user') {
    header("location:login.php");
}

$host = "localhost";
$user = "Albena";
$password = "12345678";
$db = "gymproject";

$data = mysqli_connect($host, $user, $password, $db);


$sql = "SELECT * FROM users";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <style>
        <?php include 'admin_css.php'; ?>
        form {
            margin-top: 40px;
        }
        form input, form select, form textarea {
            margin: 8px 0;
            padding: 8px;
            width: 100%;
        }
    </style>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <h2>All Registered Users</h2>
    <br>
    <table border="1px">
        <tr>
            <th style="padding:10px;">ID</th>
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Surname</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Phone</th>
            <th style="padding:10px;">Birthdate</th>
            <th style="padding:10px;">Bio</th>
            <th style="padding:10px;">Role</th>
            <th style="padding:10px;">Registered On</th>
        </tr>

        <?php while ($user = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td style="padding:10px;"><?php echo $user['id']; ?></td>
                <td style="padding:10px;"><?php echo htmlspecialchars($user['name']); ?></td>
                <td style="padding:10px;"><?php echo htmlspecialchars($user['surname']); ?></td>
                <td style="padding:10px;"><?php echo htmlspecialchars($user['email']); ?></td>
                <td style="padding:10px;"><?php echo htmlspecialchars($user['phone']); ?></td>
                <td style="padding:10px;"><?php echo $user['birthdate']; ?></td>
                <td style="padding:10px;"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></td>
                <td style="padding:10px;"><?php echo $user['role']; ?></td>
                <td style="padding:10px;"><?php echo $user['registration_date']; ?></td>
            </tr>
        <?php } ?>
    </table>

   
</div>

</body>
</html>

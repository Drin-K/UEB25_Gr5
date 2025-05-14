<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:login.php");
}elseif($_SESSION['usertype']=='user'){
header("location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
</head>
<body>
  <h1>Admin home</h1>
  <a href="logout.php">Logout</a>
</body>
</html>
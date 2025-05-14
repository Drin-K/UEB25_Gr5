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
  <title>Admin Dashboard</title>
  <style>
    <?php
    include 'admin_css.php'?>

  </style>
</head>
<body>

 <?php
 include 'admin_sidebar.php'
 ?>
  <!-- Main Content -->
  <div class="main-content">
    <h2>Welcome to the Admin Panel</h2>
    <p>Select an option from the sidebar to manage content.</p>
  </div>

</body>
</html>

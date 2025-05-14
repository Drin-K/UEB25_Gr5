<?php
session_start();
if(!isset($_SESSION['username'])){
header("location:login.php");
}elseif($_SESSION['usertype']=='user'){
header("location:login.php");
}

$host="localhost";
$user="Albena";
$password="12345678";
$db="gymproject";
$data=mysqli_connect($host, $user, $password, $db);

$sql="SELECT * from joinus";
$result=mysqli_query($data,$sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
 <?php
 include 'admin_css.php';
 ?>
  </style>
</head>
<body>
<?php
include 'admin_sidebar.php';
?>
 
  <!-- Main Content -->
  <div class="main-content">
    <h2>Applied For Admission</h2>
    <br>
    <table border="1px">
      <tr>
        <th style="padding:20px; font-size:15px;">Name</th>
        <th style="padding:20px; font-size:15px;">Surname</th>
        <th style="padding:20px; font-size:15px;">Email</th>
        <th style="padding:20px; font-size:15px;">Phone Number</th>
        <th style="padding:20px; font-size:15px;">Birthdate</th>
        <th style="padding:20px; font-size:15px;">Bio</th>
        <th style="padding:20px; font-size:15px;">Password</th>
        <th style="padding:20px; font-size:15px;">Confirmed Password</th>
        <th style="padding:20px; font-size:15px;">Membership plan</th>
</tr>
<?php
while($info=$result->fetch_assoc()){

?>
<tr>
  <td style="padding:20px;">
    <?php echo "{$info['name']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['surname']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['email']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['phone']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['birthdate']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['bio']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['password']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['confirmedpassword']}";?>
  </td>
  <td style="padding:20px;">
    <?php echo "{$info['plan']}";?>
  </td>
</tr>
<?php
}?>
</table>
   </div>

</body>
</html>

<?php
session_start();
$host="localhost";
$user="Albena";
$password="12345678";
$db="gymproject";
$data=mysqli_connect($host, $user, $password, $db);
if($data===false){
  die("connection error");
}
if(isset($_POST['apply'])){
  $data_name=$_POST['name'];
  $data_surname=$_POST['surname'];
  $data_email=$_POST['email'];
  $data_phone=$_POST['phone'];
  $data_birthdate=$_POST['birthdate'];
  $data_bio=$_POST['bio'];
  $data_password=$_POST['password'];
  $data_confirmedpassword=$_POST['password2'];
  $data_plan=$_POST['membership_plan'];

  $sql="INSERT INTO joinus(name,surname,email,phone,birthdate,bio,password,confirmedpassword,plan)
  VALUES('$data_name','$data_surname',' $data_email','$data_phone',' $data_birthdate','$data_bio','$data_password','$data_confirmedpassword','$data_plan')";

$result=mysqli_query($data,$sql);
if($result){
$_SESSION['message']="your application sent successful";
header("location:userhome.php");
}
else{
  echo "Apply Failed";
}
}

?>
<?php

error_reporting(0);//sparaqet errore veq mesazhin
 session_start();

$host="localhost";

$user="Albena";
$password="12345678";
$db="gymproject";

$data=mysqli_connect($host,$user,$password,$db);

if($data==false){
  die("connection error1");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $name=$_POST['username'];

  $pass=$_POST['password'];

  $sql="select * from user where username='".$name."' AND password='".$pass."' ";
  $result=mysqli_query($data,$sql);

  $row=mysqli_fetch_array($result);

  if($row["usertype"]=="user")
  {

    $_SESSION['username']=$name;
    $_SESSION['usertype']="user";
    header("location:userhome.php");

  }
  elseif($row["usertype"]=="admin")
  {
     $_SESSION['username']=$name;
      $_SESSION['usertype']="admin";
    header("location:adminhome.php");
  }else{
   
    $message="username or password do not match";

    $_SESSION['loginMessage']=$message;
    header("location:login.php");
  }

}








?>
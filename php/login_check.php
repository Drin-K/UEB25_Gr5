<?php

error_reporting(0); // sparaqet errore veq mesazhin
session_start();

$host = "localhost";
$user = "Albena";
$password = "12345678";
$db = "gymproject";

$data = mysqli_connect($host, $user, $password, $db);

if ($data == false) {
    die("connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $result = mysqli_query($data, $sql);
    $row = mysqli_fetch_array($result);

    if ($row && $row["password"] == $pass) {
        if ($row["role"] == "user") {
            $_SESSION['username'] = $email;
            $_SESSION['usertype'] = "user";
            header("location:userhome.php");
        } elseif ($row["role"] == "admin") {
            $_SESSION['username'] = $email;
            $_SESSION['usertype'] = "admin";
            header("location:adminhome.php");
        }
    } else {
        $message = "username or password do not match";
        $_SESSION['loginMessage'] = $message;
        header("location:login.php");
    }
}
?>

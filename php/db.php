<?php


$host = "localhost";
$user = "root";
$password = "";
$database = "fitness_manager_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>

<?php
require_once "db.php";

$addMessage = $_GET['add'] ?? '';
$deleteMessage = $_GET['delete'] ?? '';

$users = $conn->query("SELECT * FROM users");

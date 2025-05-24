<?php
if (!isset($conn)) {
    include("../db.php");
}

$memberships = $conn->query("SELECT * FROM memberships");
?>

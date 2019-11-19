<?php
$server = "localhost";
$user = "root";
$password = "";

$conn = mysqli_connect($server, $user, $password);
$db = mysqli_connect($server, $user, $password, "factorydb");

mysqli_set_charset($conn, "utf8");
mysqli_set_charset($db, "utf8");
?>
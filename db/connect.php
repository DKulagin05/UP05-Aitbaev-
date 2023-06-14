<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RealEstate";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>

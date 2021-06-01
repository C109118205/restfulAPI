<?php
/* Database connection start */
$servername = "mbeutwen.ddns.net";
$username = "test01";
$password = "minsen200110";
$dbname = "plsys";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labact2";

$conn = mysqli_connect($servername, $username, $password, $dbname, 3307);
if (!$conn) {
    die("Connection Failed" . mysqli_connect_error());
}
echo "Connect Succes";
?>

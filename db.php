<?php
$host = "projectarchive.mysql.dbaas.com.br";
$user = "projectarchive";
$pass = "Rbs250889@";
$db = "projectarchive";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'zayno';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Set character set to UTF-8
$conn->set_charset("utf8mb4");
?>


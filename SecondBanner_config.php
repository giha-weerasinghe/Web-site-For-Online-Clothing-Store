<?php
// SecondBanner_config.php

$servername = "localhost"; // Or your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "zayno"; // The database name we created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "medical_billing";  // <-- YOUR REAL DATABASE NAME

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

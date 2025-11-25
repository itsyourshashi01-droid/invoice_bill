<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "medical_billing";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_errno) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

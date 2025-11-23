<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

$id = $_GET['id'];
$conn->query("DELETE FROM customers WHERE id=$id");

header("Location: customers.php");
exit;
?>

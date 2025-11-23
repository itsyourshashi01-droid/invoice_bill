<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

$id = $_GET['id'];

$conn->query("DELETE FROM products WHERE id=$id");

header("Location: products_list.php");
exit;
?>

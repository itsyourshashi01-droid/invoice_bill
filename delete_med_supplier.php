<?php
include "db.php";

$id = $_GET['id'];

$conn->query("DELETE FROM med_supplier WHERE id = $id");

header("Location: index.php?page=supplier_stock_content.php");
exit;
?>

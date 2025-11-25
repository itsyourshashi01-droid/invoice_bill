<?php
include "db.php";

$id = $_POST['id'];

$stmt = $conn->prepare("
    UPDATE med_supplier SET
        medicine_code = ?, supplier_id = ?, invoice_no = ?, total_qty = ?, 
        free_qty = ?, total_rate = ?, total_mrp = ?, discount_percent = ?, 
        gst_percent = ?, subtotal = ?
    WHERE id = ?
");

$stmt->bind_param(
    "sisiiiddidi",
    $_POST['medicine_code'],
    $_POST['supplier_id'],
    $_POST['invoice_no'],
    $_POST['total_qty'],
    $_POST['free_qty'],
    $_POST['total_rate'],
    $_POST['total_mrp'],
    $_POST['discount_percent'],
    $_POST['gst_percent'],
    $_POST['subtotal'],
    $id
);

$stmt->execute();
$stmt->close();

echo "success";
?>

<?php
include "db.php";  // your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $medicine_code   = $_POST['medicine_code'];
    $supplier_id     = $_POST['supplier_id'];
    $invoice_no      = $_POST['invoice_no'];
    $total_qty       = $_POST['total_qty'];
    $free_qty        = $_POST['free_qty'];
    $total_rate      = $_POST['total_rate'];
    $total_mrp       = $_POST['total_mrp'];
    $discount_percent= $_POST['discount_percent'];
    $gst_percent     = $_POST['gst_percent'];
    $subtotal        = $_POST['subtotal'];

    $stmt = $conn->prepare("
        INSERT INTO med_supplier 
        (medicine_code, supplier_id, invoice_no, total_qty, free_qty, total_rate, total_mrp, discount_percent, gst_percent, subtotal)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sisiiiddid",
        $medicine_code,
        $supplier_id,
        $invoice_no,
        $total_qty,
        $free_qty,
        $total_rate,
        $total_mrp,
        $discount_percent,
        $gst_percent,
        $subtotal
    );

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

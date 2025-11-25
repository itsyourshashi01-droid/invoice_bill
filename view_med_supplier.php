<?php
include "db.php";

$id = $_GET['id'];
$res = $conn->query("
    SELECT m.*, s.name AS supplier_name 
    FROM med_supplier m
    LEFT JOIN suppliers s ON m.supplier_id = s.id
    WHERE m.id = $id
")->fetch_assoc();
?>

<div class="content-box">
    <h2>View Medicine Supplier Stock</h2>
    <hr>

    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $res['id'] ?></td></tr>
        <tr><th>Medicine Code</th><td><?= $res['medicine_code'] ?></td></tr>
        <tr><th>Supplier</th><td><?= $res['supplier_name'] ?></td></tr>
        <tr><th>Invoice No</th><td><?= $res['invoice_no'] ?></td></tr>
        <tr><th>Total Qty</th><td><?= $res['total_qty'] ?></td></tr>
        <tr><th>Free Qty</th><td><?= $res['free_qty'] ?></td></tr>
        <tr><th>Total Rate</th><td><?= $res['total_rate'] ?></td></tr>
        <tr><th>Total MRP</th><td><?= $res['total_mrp'] ?></td></tr>
        <tr><th>Discount %</th><td><?= $res['discount_percent'] ?></td></tr>
        <tr><th>GST %</th><td><?= $res['gst_percent'] ?></td></tr>
        <tr><th>Subtotal</th><td><?= $res['subtotal'] ?></td></tr>
    </table>

    <button class="btn btn-secondary ajax-link" data-page="supplier_stock_content.php">Back</button>
</div>

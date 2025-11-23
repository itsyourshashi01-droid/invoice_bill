<?php
$conn = new mysqli("localhost", "root", "", "Om Pharma & Surgical billing");

$invoice_id = $_GET['id'];

// Fetch invoice
$inv = $conn->query("SELECT * FROM invoices WHERE id = $invoice_id")->fetch_assoc();

// Fetch items
$items = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $invoice_id");

// Fetch medical profile (your business)
$profile = $conn->query("SELECT * FROM medical_profile LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice <?= $inv['bill_no']; ?></title>

<style>
body {
    font-family: Arial, sans-serif;
    padding: 20px;
}

.invoice-box {
    width: 100%;
    border: 1px solid #000;
    padding: 15px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table th, .table td {
    border: 1px solid #000;
    padding: 6px;
    font-size: 14px;
}

.header-table td {
    border: none !important;
    padding: 2px;
}

.text-right { text-align: right; }
.text-center { text-align: center; }

@media print {
    .no-print { display: none; }
}
</style>
</head>

<body>

<div class="no-print">
    <button onclick="window.print()">Print Invoice</button>
    <br><br>
</div>

<div class="invoice-box">

    <!-- Business Header -->
    <table class="header-table" width="100%">
        <tr>
            <td width="20%">
                <img src="uploads/<?= $profile['logo']; ?>" width="90">
            </td>
            <td width="80%">
                <h2><?= $profile['medical_name']; ?></h2>
                <?= $profile['address']; ?><br>
                Phone: <?= $profile['phone']; ?><br>
                GST No: <?= $profile['gst_no']; ?> | DL No: <?= $profile['dl_no']; ?>
            </td>
        </tr>
    </table>

    <hr>

    <!-- Invoice Details -->
    <table width="100%">
        <tr>
            <td><b>Bill No:</b> <?= $inv['bill_no']; ?></td>
            <td><b>Date:</b> <?= date("d-m-Y", strtotime($inv['date_time'])); ?></td>
        </tr>
        <tr>
            <td><b>Customer:</b> <?= $inv['customer_name']; ?></td>
            <td><b>Doctor:</b> <?= $inv['doctor_name']; ?></td>
        </tr>
        <tr>
            <td><b>Reg No:</b> <?= $inv['reg_no']; ?></td>
            <td></td>
        </tr>
    </table>

    <br>

    <!-- Items Table -->
    <table class="table">
        <tr>
            <th>S.No</th>
            <th>Product</th>
            <th>Batch</th>
            <th>Expiry</th>
            <th>HSN</th>
            <th>MFG</th>
            <th>Qty</th>
            <th>MRP</th>
            <th>Disc %</th>
            <th>GST %</th>
            <th>Total</th>
        </tr>

        <?php 
        $sn = 1;
        $grand_total = 0;

        while ($row = $items->fetch_assoc()) {
            $grand_total += $row['amount'];
        ?>
        <tr>
            <td><?= $sn++; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['batch']; ?></td>
            <td><?= $row['expiry']; ?></td>
            <td><?= $row['hsn']; ?></td>
            <td><?= $row['mfg']; ?></td>
            <td><?= $row['qty']; ?></td>
            <td><?= number_format($row['mrp'], 2); ?></td>
            <td><?= $row['discount_percent']; ?></td>
            <td><?= $row['gst_percent']; ?></td>
            <td><?= number_format($row['amount'], 2); ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td colspan="10" class="text-right"><b>Grand Total</b></td>
            <td><b><?= number_format($grand_total, 2); ?></b></td>
        </tr>
    </table>

    <br><br>

    <p style="text-align:center;">** Thank You For Your Business **</p>

</div>

</body>
</html>

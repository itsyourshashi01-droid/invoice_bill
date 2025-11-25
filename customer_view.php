<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

$id = $_GET['id'];

// FETCH CUSTOMER
$customer = $conn->query("SELECT * FROM customers WHERE id = $id")->fetch_assoc();

// FETCH ALL INVOICES FOR THIS CUSTOMER
$invoices = $conn->query("SELECT * FROM invoices WHERE customer_id = $id ORDER BY id DESC");

// CALCULATE CUSTOMER TOTAL PURCHASE VALUE
$total_amount = $conn->query("SELECT SUM(grand_total) AS total FROM invoices WHERE customer_id = $id")
                     ->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Details</title>

<style>
body { background:#1f1f1f; font-family:Arial; color:white; padding:20px; }

.container {
    width: 850px;
    margin:auto;
    background:#2d2d2d;
    padding:20px;
    border-radius:12px;
    box-shadow:0 0 12px rgba(0,0,0,0.5);
}

h2 { text-align:center; margin-bottom:10px; }

.info-box {
    background:#242424;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    border:1px solid #3b3b3b;
}

.info-box p { font-size:17px; }

.action-btns a {
    background:#0078d4;
    color:white;
    padding:8px 14px;
    border-radius:6px;
    margin-right:10px;
    text-decoration:none;
}

.action-btns a:hover { background:#0893ff; }

table {
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

th, td {
    padding:10px;
    border:1px solid #444;
    text-align:center;
}

th {
    background:#333;
}
</style>

</head>
<body>

<div class="container">

<h2>Customer Details</h2>

<div class="info-box">
    <p><b>Name:</b> <?= $customer['customer_name']; ?></p>
    <p><b>Doctor / Hospital:</b> <?= $customer['doctor_name']; ?></p>
    <p><b>Address:</b> <?= nl2br($customer['address']); ?></p>
    <p><b>GSTIN:</b> <?= $customer['gstin']; ?></p>
</div>

<div class="action-btns">
    <a href="invoice_create.php?customer_id=<?= $id ?>">New Invoice</a>
    <a href="customers_edit.php?id=<?= $id ?>">Edit</a>
    <a href="customers_delete.php?id=<?= $id ?>"
       onclick="return confirm('Delete customer? All invoices will remain but customer is removed')">
       Delete
    </a>
    <a href="customers_list.php" style="background:#555;">Back</a>
</div>

<h3>Total Business: ₹ <?= number_format($total_amount, 2); ?></h3>

<hr>

<h3>Invoice History</h3>

<table>
<tr>
    <th>Bill No</th>
    <th>Date</th>
    <th>Subtotal</th>
    <th>Discount</th>
    <th>GST</th>
    <th>Grand Total</th>
    <th>Action</th>
</tr>

<?php while ($inv = $invoices->fetch_assoc()) { ?>
<tr>
    <td><?= $inv['bill_no']; ?></td>
    <td><?= $inv['date_time']; ?></td>
    <td><?= number_format($inv['subtotal'],2); ?></td>
    <td><?= $inv['discount_percent']; ?>%</td>
    <td><?= $inv['gst_percent']; ?>%</td>
    <td><b><?= number_format($inv['grand_total'],2); ?></b></td>
    <td>
        <a href="invoice_print.php?id=<?= $inv['id']; ?>">Print</a> |
        <a href="invoice_pdf.php?id=<?= $inv['id']; ?>">PDF</a> |
        <a href="invoice_delete.php?id=<?= $inv['id']; ?>"
           onclick="return confirm('Delete invoice? Stock will be restored.')">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>

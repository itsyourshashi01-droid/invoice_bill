<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

// TOTAL SALES
$total_sales = $conn->query("SELECT SUM(grand_total) AS total FROM invoices")->fetch_assoc()['total'];
$total_sales = $total_sales ?: 0;

// TODAY SALES
$today = date("Y-m-d");
$today_sales = $conn->query("SELECT SUM(grand_total) AS total FROM invoices WHERE DATE(date_time)='$today'")
                    ->fetch_assoc()['total'];
$today_sales = $today_sales ?: 0;

// TOTAL INVOICES
$total_invoices = $conn->query("SELECT COUNT(*) AS c FROM invoices")->fetch_assoc()['c'];

// TOTAL CUSTOMERS
$total_customers = $conn->query("SELECT COUNT(*) AS c FROM customers")->fetch_assoc()['c'];

// LAST 10 INVOICES
$latest = $conn->query("SELECT * FROM invoices ORDER BY id DESC LIMIT 10");

?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body { font-family: Arial; padding:20px; }
.box-container { display:flex; gap:20px; }
.box {
    flex:1;
    padding:20px;
    background:#f7f7f7;
    border:1px solid #ccc;
    font-size:20px;
    text-align:center;
}
table { width:100%; margin-top:30px; border-collapse: collapse; }
th, td { border:1px solid #000; padding:8px; text-align:center; }
</style>
</head>
<body>

<h1>Dashboard</h1>

<div class="box-container">
    <div class="box">
        <b>Total Sales</b><br>
        ₹ <?= number_format($total_sales, 2); ?>
    </div>

    <div class="box">
        <b>Today's Sales</b><br>
        ₹ <?= number_format($today_sales, 2); ?>
    </div>

    <div class="box">
        <b>Total Invoices</b><br>
        <?= $total_invoices; ?>
    </div>

    <div class="box">
        <b>Total Customers</b><br>
        <?= $total_customers; ?>
    </div>
</div>

<h2>Latest 10 Invoices</h2>

<table>
<tr>
    <th>ID</th>
    <th>Bill No</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Doctor</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php while($row = $latest->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['bill_no']; ?></td>
    <td><?= date("d-m-Y h:i A", strtotime($row['date_time'])); ?></td>
    <td><?= $row['customer_name']; ?></td>
    <td><?= $row['doctor_name']; ?></td>
    <td>₹ <?= number_format($row['grand_total'], 2); ?></td>
    <td>
        <a target="_blank" href="print_invoice.php?id=<?= $row['id']; ?>">Print</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// FETCH ALL CUSTOMERS FOR FILTER DROPDOWN
$customers = $conn->query("SELECT * FROM customers ORDER BY customer_name ASC");

// FETCH INVOICES
$query = "SELECT * FROM invoices ORDER BY id DESC";

// APPLY FILTERS
if (!empty($_GET['customer_id'])) {
    $cid = $_GET['customer_id'];
    $query = "SELECT * FROM invoices WHERE customer_id = $cid ORDER BY id DESC";
}

if (!empty($_GET['bill_no'])) {
    $bno = $_GET['bill_no'];
    $query = "SELECT * FROM invoices WHERE bill_no LIKE '%$bno%' ORDER BY id DESC";
}

if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from = $_GET['from_date'];
    $to = $_GET['to_date'];
    $query = "SELECT * FROM invoices WHERE date_time BETWEEN '$from' AND '$to' ORDER BY id DESC";
}

$invoices = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice List</title>

<style>
table { width:100%; border-collapse: collapse; margin-top:20px; }
td, th { border:1px solid #444; padding:8px; text-align:center; }
input, select { padding:6px; margin-right:10px; }
a { text-decoration:none; }
</style>
</head>
<body>

<h2>Invoice List</h2>

<a href="invoice_create.php">+ Create New Invoice</a>

<br><br>

<!-- FILTER SECTION -->
<form method="GET">
    <select name="customer_id">
        <option value="">All Customers</option>
        <?php while($c = $customers->fetch_assoc()) { ?>
            <option value="<?= $c['id']; ?>"
                <?php if(isset($_GET['customer_id']) && $_GET['customer_id'] == $c['id']) echo 'selected'; ?>>
                <?= $c['customer_name']; ?>
            </option>
        <?php } ?>
    </select>

    <input type="text" name="bill_no" placeholder="Search Bill No"
           value="<?= $_GET['bill_no'] ?? ''; ?>">

    <input type="date" name="from_date"
           value="<?= $_GET['from_date'] ?? ''; ?>">
    <input type="date" name="to_date"
           value="<?= $_GET['to_date'] ?? ''; ?>">

    <button type="submit">Filter</button>
</form>

<br>

<table>
<tr>
    <th>ID</th>
    <th>Bill No</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Doctor/Hospital</th>
    <th>Subtotal</th>
    <th>Discount %</th>
    <th>GST %</th>
    <th>Grand Total</th>
    <th>Action</th>
</tr>

<?php while ($inv = $invoices->fetch_assoc()) { ?>
<tr>
    <td><?= $inv['id']; ?></td>
    <td><?= $inv['bill_no']; ?></td>
    <td><?= $inv['date_time']; ?></td>
    <td><?= $inv['customer_name']; ?></td>
    <td><?= $inv['doctor_name']; ?></td>
    <td><?= number_format($inv['subtotal'], 2); ?></td>
    <td><?= $inv['discount_percent']; ?></td>
    <td><?= $inv['gst_percent']; ?></td>
    <td><b><?= number_format($inv['grand_total'], 2); ?></b></td>

    <td>
        <a href="invoice_print.php?id=<?= $inv['id']; ?>">Print</a> |
        <a href="invoice_pdf.php?id=<?= $inv['id']; ?>" target="_blank">PDF</a> |
        <a href="invoice_delete.php?id=<?= $inv['id']; ?>"
           onclick="return confirm('Delete invoice? Stock will be restored.')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

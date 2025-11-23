<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// FETCH ALL PURCHASE BILLS
$result = $conn->query("SELECT * FROM purchases ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Purchase Bills</title>
<style>
table { width:100%; border-collapse: collapse; margin-top:20px; }
td, th { border:1px solid #444; padding:8px; text-align:center; }
a { text-decoration:none; }
button { padding:4px 10px; }
</style>
</head>
<body>

<h2>Purchase Bills</h2>

<a href="purchase_add.php">+ Add Purchase</a>

<table>
<tr>
    <th>ID</th>
    <th>Supplier</th>
    <th>Bill No</th>
    <th>Date</th>
    <th>Total Amount</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['supplier_name']; ?></td>
    <td><?= $row['bill_no']; ?></td>
    <td><?= $row['date']; ?></td>
    <td>₹ <?= number_format($row['total_amount'], 2); ?></td>

    <td>
        <a href="purchase_delete.php?id=<?= $row['id']; ?>" 
           onclick="return confirm('Delete this purchase? Stock will decrease. Continue?');">
            Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

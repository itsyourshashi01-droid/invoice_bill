<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");
$result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customers</title>
<style>
table { width:100%; border-collapse: collapse; margin-top:20px; }
td, th { border:1px solid #444; padding:8px; text-align:center; }
a { text-decoration:none; }
</style>
</head>
<body>

<h2>Customer List</h2>

<a href="customers_add.php">+ Add Customer</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Doctor/Hospital</th>
    <th>Contact</th>
    <th>Address</th>
    <th>GSTIN</th>
    <th>Action</th>
</tr>

<?php while ($c = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $c['id']; ?></td>
    <td><?= $c['customer_name']; ?></td>
    <td><?= $c['doctor_name']; ?></td>
    <td><?= $c['contact']; ?></td>
    <td><?= $c['address']; ?></td>
    <td><?= $c['gstin']; ?></td>

    <td>
        <a href="customers_edit.php?id=<?= $c['id']; ?>">Edit</a> |
        <a href="customers_delete.php?id=<?= $c['id']; ?>"
           onclick="return confirm('Delete customer?');">
            Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

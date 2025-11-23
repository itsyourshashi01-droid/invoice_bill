<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");
$result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer List</title>
<style>
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #000; padding:8px; text-align:center; }
.btn-edit { padding:5px 10px; background:#007bff; color:#fff; border:none; }
.btn-delete { padding:5px 10px; background:#dc3545; color:#fff; border:none; }
.btn-add { padding:8px 15px; background:#28a745; color:#fff; border:none; text-decoration:none; }
</style>
</head>
<body>

<h2>Customers</h2>

<a href="customers_add.php" class="btn-add">+ Add Customer</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Type</th>
    <th>Phone</th>
    <th>GST No</th>
    <th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['type']; ?></td>
    <td><?= $row['phone']; ?></td>
    <td><?= $row['gst_no']; ?></td>

    <td>
        <a href="customers_edit.php?id=<?= $row['id']; ?>">
            <button class="btn-edit">Edit</button>
        </a>

        <a onclick="return confirm('Delete this customer?')"
           href="customers_delete.php?id=<?= $row['id']; ?>">
            <button class="btn-delete">Delete</button>
        </a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// BUILD QUERY
$query = "SELECT * FROM customers WHERE 1";

// SEARCH BY NAME
if (!empty($_GET['search'])) {
    $s = $_GET['search'];
    $query .= " AND (customer_name LIKE '%$s%' OR doctor_name LIKE '%$s%' 
                OR address LIKE '%$s%' OR gstin LIKE '%$s%')";
}

// FILTER BY CITY (OPTIONAL)
if (!empty($_GET['city'])) {
    $city = $_GET['city'];
    $query .= " AND address LIKE '%$city%'";
}

$query .= " ORDER BY customer_name ASC";

$customers = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer List</title>
<style>
body { font-family: Arial; background: #1f1f1f; color: white; padding: 20px; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #2d2d2d;
}

table th, table td {
    border: 1px solid #444;
    padding: 10px;
    text-align: center;
}

input, select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #444;
    background: #2a2a2a;
    color: white;
}

a { color: #4da3ff; text-decoration: none; }
a:hover { text-decoration: underline; }

.btn {
    background: #0078d4;
    padding: 6px 14px;
    border-radius: 6px;
    color: white;
    text-decoration: none;
}
</style>
</head>

<body>

<h2>Customers</h2>

<a href="customers_add.php" class="btn">+ Add Customer</a>
<br><br>

<!-- SEARCH + FILTER FORM -->
<form method="GET">
    
    <input type="text" name="search" placeholder="Search name, doctor, address, GSTIN"
           value="<?= $_GET['search'] ?? '' ?>" style="width: 350px;">

    <select name="city">
        <option value="">All Cities</option>
        <option value="Hospital" <?php if(($_GET['city'] ?? '')=="Hospital") echo "selected"; ?>>Hospitals</option>
        <option value="Clinic"   <?php if(($_GET['city'] ?? '')=="Clinic") echo "selected"; ?>>Clinics</option>
        <option value="Shop"     <?php if(($_GET['city'] ?? '')=="Shop") echo "selected"; ?>>Medical Shops</option>
    </select>

    <button class="btn">Search</button>
</form>

<table>
<tr>
    <th>ID</th>
    <th>Customer Name</th>
    <th>Doctor / Hospital</th>
    <th>Address</th>
    <th>GSTIN</th>
    <th>Action</th>
</tr>

<?php while ($c = $customers->fetch_assoc()) { ?>
<tr>
    <td><?= $c['id']; ?></td>
    <td><?= $c['customer_name']; ?></td>
    <td><?= $c['doctor_name']; ?></td>
    <td><?= nl2br($c['address']); ?></td>
    <td><?= $c['gstin']; ?></td>

    <td>
        <a href="customers_edit.php?id=<?= $c['id']; ?>">Edit</a> |
        <a href="customer_view.php?id=<?= $c['id']; ?>">View</a> |
        <a href="customers_delete.php?id=<?= $c['id']; ?>"
           onclick="return confirm('Delete this customer?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

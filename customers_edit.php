<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");
$id = $_GET['id'];
$c = $conn->query("SELECT * FROM customers WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['customer_name'];
    $docname = $_POST['doctor_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gstin = $_POST['gstin'];

    $conn->query("
        UPDATE customers 
        SET customer_name='$name',
            doctor_name='$docname',
            contact='$contact',
            address='$address',
            gstin='$gstin'
        WHERE id=$id
    ");

    header("Location: customers.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Customer</title></head>
<body>

<h2>Edit Customer</h2>

<form method="POST">

<label>Customer Name:</label>
<input type="text" name="customer_name" value="<?= $c['customer_name']; ?>" required><br><br>

<label>Doctor / Hospital Name:</label>
<input type="text" name="doctor_name" value="<?= $c['doctor_name']; ?>"><br><br>

<label>Contact:</label>
<input type="text" name="contact" value="<?= $c['contact']; ?>"><br><br>

<label>Address:</label>
<textarea name="address"><?= $c['address']; ?></textarea><br><br>

<label>GSTIN:</label>
<input type="text" name="gstin" value="<?= $c['gstin']; ?>"><br><br>

<button type="submit">Update</button>

</form>

</body>
</html>

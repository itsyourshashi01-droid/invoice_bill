<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['customer_name'];
    $docname = $_POST['doctor_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gstin = $_POST['gstin'];

    $conn->query("
        INSERT INTO customers (customer_name, doctor_name, contact, address, gstin)
        VALUES ('$name', '$docname', '$contact', '$address', '$gstin')
    ");

    header("Location: customers.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Customer</title></head>
<body>

<h2>Add Customer</h2>

<form method="POST">

<label>Customer Name:</label>
<input type="text" name="customer_name" required><br><br>

<label>Doctor / Hospital Name:</label>
<input type="text" name="doctor_name"><br><br>

<label>Contact:</label>
<input type="text" name="contact"><br><br>

<label>Address:</label>
<textarea name="address"></textarea><br><br>

<label>GSTIN:</label>
<input type="text" name="gstin"><br><br>

<button type="submit">Save Customer</button>

</form>

</body>
</html>

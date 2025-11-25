<?php
include "db.php";

$name   = $_POST['customer_name'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$gstin   = $_POST['gstin'];
$doctor  = $_POST['doctor_name'];

$sql = "INSERT INTO customers (customer_name, contact, address, gstin, doctor_name, created_on)
        VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $contact, $address, $gstin, $doctor);

if ($stmt->execute()) {
    header("Location: customers.php?success=1");
} else {
    echo "Error: " . $conn->error;
}
?>

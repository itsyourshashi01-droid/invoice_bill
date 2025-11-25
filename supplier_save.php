<?php
include "db.php";

$name   = $_POST['supplier_name'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$gstin   = $_POST['gstin'];
$type    = $_POST['type'];

$sql = "INSERT INTO suppliers (supplier_name, contact, address, gstin, type, created_on)
        VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $contact, $address, $gstin, $type);

if ($stmt->execute()) {
    header("Location: suppliers.php?success=1");
} else {
    echo "Error: " . $conn->error;
}
?>

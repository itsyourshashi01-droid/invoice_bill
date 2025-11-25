<?php
include("db.php");

$stmt = $conn->prepare("
INSERT INTO suppliers (name, contact_person, phone, email, address, gst_no, pan_no)
VALUES (?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "sssssss",
    $_POST['name'],
    $_POST['contact_person'],
    $_POST['phone'],
    $_POST['email'],
    $_POST['address'],
    $_POST['gst_no'],
    $_POST['pan_no']
);

$stmt->execute();
echo "OK";
?>

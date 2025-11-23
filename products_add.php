<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($_SERVER['REQUEST_METHOD']=="POST") {
    $name = $_POST['product_name'];
    $batch = $_POST['batch'];
    $expiry = $_POST['expiry'];
    $mfg = $_POST['mfg'];
    $hsn = $_POST['hsn'];
    $mrp = $_POST['mrp'];
    $gst = $_POST['gst_percent'];
    $purchase = $_POST['purchase_rate'];
    $qty = $_POST['qty'];

    $conn->query("INSERT INTO products 
        (product_name, batch, expiry, mfg, hsn, mrp, gst_percent, purchase_rate, qty, added_on)
        VALUES ('$name', '$batch', '$expiry', '$mfg', '$hsn', '$mrp', '$gst', '$purchase', '$qty', NOW())");

    header("Location: products_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<style>
input { width:100%; padding:6px; margin-bottom:10px; }
</style>
</head>
<body>

<h2>Add Product to Stock</h2>

<form method="POST">

    <label>Product Name</label>
    <input type="text" name="product_name" required>

    <label>Batch No</label>
    <input type="text" name="batch" required>

    <label>Expiry Date</label>
    <input type="date" name="expiry" required>

    <label>Manufacturer</label>
    <input type="text" name="mfg">

    <label>HSN</label>
    <input type="text" name="hsn">

    <label>MRP</label>
    <input type="number" step="0.01" name="mrp">

    <label>GST %</label>
    <input type="number" step="0.01" name="gst_percent">

    <label>Purchase Rate</label>
    <input type="number" step="0.01" name="purchase_rate">

    <label>Quantity</label>
    <input type="number" name="qty">

    <button type="submit">Save Product</button>

</form>

</body>
</html>

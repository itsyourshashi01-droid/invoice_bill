<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

$id = $_GET['id'];

// Fetch product data
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_POST['product_name'];
    $batch = $_POST['batch'];
    $expiry = $_POST['expiry'];
    $mfg = $_POST['mfg'];
    $hsn = $_POST['hsn'];
    $mrp = $_POST['mrp'];
    $gst = $_POST['gst_percent'];
    $purchase = $_POST['purchase_rate'];
    $qty = $_POST['qty'];

    $conn->query("
        UPDATE products SET
            product_name='$name',
            batch='$batch',
            expiry='$expiry',
            mfg='$mfg',
            hsn='$hsn',
            mrp='$mrp',
            gst_percent='$gst',
            purchase_rate='$purchase',
            qty='$qty'
        WHERE id=$id
    ");

    header("Location: products_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<style>
input { width:100%; padding:6px; margin-bottom:10px; }
</style>
</head>

<body>

<h2>Edit Product</h2>

<form method="POST">

    <label>Product Name</label>
    <input type="text" name="product_name" value="<?= $product['product_name']; ?>" required>

    <label>Batch No</label>
    <input type="text" name="batch" value="<?= $product['batch']; ?>" required>

    <label>Expiry</label>
    <input type="date" name="expiry" value="<?= $product['expiry']; ?>" required>

    <label>Manufacturer</label>
    <input type="text" name="mfg" value="<?= $product['mfg']; ?>">

    <label>HSN</label>
    <input type="text" name="hsn" value="<?= $product['hsn']; ?>">

    <label>MRP</label>
    <input type="number" step="0.01" name="mrp" value="<?= $product['mrp']; ?>">

    <label>GST %</label>
    <input type="number" step="0.01" name="gst_percent" value="<?= $product['gst_percent']; ?>">

    <label>Purchase Rate</label>
    <input type="number" step="0.01" name="purchase_rate" value="<?= $product['purchase_rate']; ?>">

    <label>Quantity</label>
    <input type="number" name="qty" value="<?= $product['qty']; ?>">

    <button type="submit">Update Product</button>

</form>

</body>
</html>

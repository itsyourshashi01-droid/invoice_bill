<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// -------------------------------
// FETCH INVOICE HEADER VALUES
// -------------------------------
$customer_id     = $_POST['customer_id'];
$customer_name   = $_POST['customer_name'];
$doctor_name     = $_POST['doctor_name'];
$address         = $_POST['address'];
$gstin           = $_POST['gstin'];

$bill_no         = $_POST['bill_no'];
$date_time       = $_POST['date_time'];

$subtotal        = $_POST['subtotal'];
$discount_percent= $_POST['discount_percent'];
$gst_percent     = $_POST['gst_percent'];
$grand_total     = $_POST['grand_total'];

// -------------------------------
// INSERT INTO INVOICES TABLE
// -------------------------------
$query = "
INSERT INTO invoices 
(customer_id, customer_name, doctor_name, address, gstin, bill_no, date_time, subtotal, discount_percent, gst_percent, grand_total)
VALUES 
('$customer_id', '$customer_name', '$doctor_name', '$address', '$gstin', '$bill_no', '$date_time', '$subtotal', '$discount_percent', '$gst_percent', '$grand_total')
";

if (!$conn->query($query)) {
    die("ERROR inserting invoice: " . $conn->error);
}

$invoice_id = $conn->insert_id;

// -------------------------------
// INSERT INVOICE ITEMS + UPDATE STOCK
// -------------------------------
for ($i = 0; $i < count($_POST['product_id']); $i++) {

    $product_id = $_POST['product_id'][$i];
    $batch      = $_POST['batch'][$i];
    $expiry     = $_POST['expiry'][$i];
    $hsn        = $_POST['hsn'][$i];
    $mfg        = $_POST['mfg'][$i];

    $qty        = floatval($_POST['qty'][$i]);
    $mrp        = floatval($_POST['mrp'][$i]);
    $discount   = floatval($_POST['discount'][$i]);
    $gst        = floatval($_POST['gst'][$i]);

    if ($product_id == "") continue; // skip empty rows

    // CALCULATE AMOUNT
    $base = $qty * $mrp;
    $discountAmt = ($base * $discount) / 100;
    $afterDiscount = $base - $discountAmt;
    $gstAmt = ($afterDiscount * $gst) / 100;
    $finalAmount = $afterDiscount + $gstAmt;

    // INSERT ITEM
    $conn->query("
        INSERT INTO invoice_items
        (invoice_id, product_id, batch, expiry, hsn, mfg, qty, mrp, discount_percent, gst_percent, amount)
        VALUES
        ($invoice_id, $product_id, '$batch', '$expiry', '$hsn', '$mfg', $qty, $mrp, $discount, $gst, $finalAmount)
    ");

    // REDUCE STOCK
    $conn->query("
        UPDATE products 
        SET qty = qty - $qty 
        WHERE id = $product_id
    ");
}

// REDIRECT
header("Location: invoice_list.php");
exit;

?>

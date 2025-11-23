<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// GET PURCHASE HEADER VALUES
$supplier = $_POST['supplier_name'];
$bill_no  = $_POST['bill_no'];
$date     = $_POST['date'];
$total    = $_POST['total_amount'];

// -----------------------------------------------
// INSERT INTO PURCHASE TABLE
// -----------------------------------------------
$conn->query("
    INSERT INTO purchases (supplier_name, bill_no, date, total_amount)
    VALUES ('$supplier', '$bill_no', '$date', '$total')
");

$purchase_id = $conn->insert_id;

// -----------------------------------------------
// INSERT PURCHASE ITEMS + UPDATE STOCK
// -----------------------------------------------
for ($i = 0; $i < count($_POST['product_name']); $i++) {

    $name   = $_POST['product_name'][$i];
    $batch  = $_POST['batch'][$i];
    $expiry = $_POST['expiry'][$i];
    $hsn    = $_POST['hsn'][$i];
    $mfg    = $_POST['mfg'][$i];
    $mrp    = $_POST['mrp'][$i];
    $gst    = $_POST['gst_percent'][$i];
    $p_rate = $_POST['purchase_rate'][$i];
    $qty    = $_POST['qty'][$i];

    $amount = $qty * $p_rate;

    // -----------------------------------------------
    // SAVE ITEM TO purchase_items TABLE
    // -----------------------------------------------
    $conn->query("
        INSERT INTO purchase_items
        (purchase_id, product_name, batch, expiry, mfg, hsn, mrp, gst_percent, purchase_rate, qty, amount)
        VALUES ($purchase_id, '$name', '$batch', '$expiry', '$mfg', '$hsn', $mrp, $gst, $p_rate, $qty, $amount)
    ");

    // -----------------------------------------------
    // CHECK IF PRODUCT WITH SAME BATCH ALREADY EXISTS
    // -----------------------------------------------
    $check = $conn->query("
        SELECT id FROM products 
        WHERE product_name='$name' AND batch='$batch'
    ");

    if ($check->num_rows > 0) {

        // SAME PRODUCT + BATCH FOUND → UPDATE STOCK QTY
        $pid = $check->fetch_assoc()['id'];

        $conn->query("
            UPDATE products 
            SET qty = qty + $qty, 
                mrp = $mrp,
                gst_percent = $gst,
                hsn = '$hsn',
                mfg = '$mfg',
                expiry = '$expiry'
            WHERE id = $pid
        ");

    } else {

        // NEW PRODUCT OR NEW BATCH → ADD NEW STOCK ROW
        $conn->query("
            INSERT INTO products 
            (product_name, batch, expiry, mfg, hsn, mrp, gst_percent, purchase_rate, qty, added_on)
            VALUES ('$name', '$batch', '$expiry', '$mfg', '$hsn', $mrp, $gst, $p_rate, $qty, NOW())
        ");
    }
}

// Redirect to purchase list
header("Location: purchase_list.php");
exit;
?>

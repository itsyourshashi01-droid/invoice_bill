<?php
// product_add_ajax.php
include("db.php");
header('Content-Type: application/json');

$product_name = $conn->real_escape_string($_POST['product_name'] ?? '');
$batch        = $conn->real_escape_string($_POST['batch'] ?? '');
$expiry       = $conn->real_escape_string($_POST['expiry'] ?? null);
$mrp          = floatval($_POST['mrp'] ?? 0);
$purchase_rate= floatval($_POST['purchase_rate'] ?? 0);
$gst_percent  = floatval($_POST['gst_percent'] ?? 0);
$hsn          = $conn->real_escape_string($_POST['hsn'] ?? '');
$mfg          = $conn->real_escape_string($_POST['mfg'] ?? '');
$qty          = intval($_POST['qty'] ?? 0);

if($product_name == '' || $batch == ''){
    echo json_encode(['success'=>false,'error'=>'Product name and batch required']);
    exit;
}

// Insert product
$sql = "INSERT INTO products (product_name, batch, expiry, mfg, hsn, mrp, gst_percent, purchase_rate, qty, added_on)
        VALUES ('$product_name', '$batch', ".($expiry? "'$expiry'":"NULL").", '$mfg', '$hsn', $mrp, $gst_percent, $purchase_rate, $qty, NOW())";

if($conn->query($sql)){
    $id = $conn->insert_id;
    $product = [
        'id' => $id,
        'product_name' => $product_name,
        'batch' => $batch,
        'expiry' => $expiry,
        'hsn' => $hsn,
        'mfg' => $mfg,
        'mrp' => $mrp,
        'gst_percent' => $gst_percent,
        'qty' => $qty
    ];
    echo json_encode(['success'=>true,'product'=>$product]);
} else {
    echo json_encode(['success'=>false,'error'=>$conn->error]);
}

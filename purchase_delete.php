<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

// PURCHASE ID
$id = $_GET['id'];

// GET PURCHASE ITEMS TO REVERSE STOCK
$items = $conn->query("SELECT * FROM purchase_items WHERE purchase_id = $id");

// REDUCE STOCK FOR EACH ITEM
while ($item = $items->fetch_assoc()) {

    $name  = $item['product_name'];
    $batch = $item['batch'];
    $qty   = $item['qty'];

    // Reduce stock from products table
    $conn->query("
        UPDATE products 
        SET qty = qty - $qty 
        WHERE product_name = '$name' AND batch = '$batch'
    ");
}

// DELETE MAIN PURCHASE RECORD (purchase_items auto deleted due to foreign key)
$conn->query("DELETE FROM purchases WHERE id = $id");

// Redirect back
header("Location: purchase_list.php");
exit;
?>

<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

if ($conn->connect_error) {
    die("DB ERROR: " . $conn->connect_error);
}

$id = $_GET['id'];

//------------------------------------
// FETCH INVOICE ITEMS FIRST
//------------------------------------
$items = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $id");

//------------------------------------
// RESTORE STOCK FOR EACH ITEM
//------------------------------------
while ($item = $items->fetch_assoc()) {
    $product_id = $item['product_id'];
    $qty = $item['qty'];

    // Increase stock back
    $conn->query("
        UPDATE products 
        SET qty = qty + $qty 
        WHERE id = $product_id
    ");
}

//------------------------------------
// DELETE INVOICE (items auto delete only if FK set)
//------------------------------------
$conn->query("DELETE FROM invoices WHERE id = $id");

// Delete invoice items manually if needed
$conn->query("DELETE FROM invoice_items WHERE invoice_id = $id");

//------------------------------------
// REDIRECT BACK
//------------------------------------
header("Location: invoice_list.php");
exit;

?>

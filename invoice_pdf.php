<?php
require_once __DIR__ . '/mpdf/vendor/autoload.php';

$conn = new mysqli("localhost", "root", "", "medical_billing");

$id = $_GET['id'];

// FETCH INVOICE
$invoice = $conn->query("SELECT * FROM invoices WHERE id=$id")->fetch_assoc();

// FETCH ITEMS
$items = $conn->query("
    SELECT invoice_items.*, products.product_name 
    FROM invoice_items 
    LEFT JOIN products ON products.id = invoice_items.product_id 
    WHERE invoice_items.invoice_id = $id
");

// HTML CONTENT STARTS
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial, sans-serif; }
table { width:100%; border-collapse:collapse; }
th, td { border:1px solid #444; padding:6px; text-align:center; }
h2, h3 { text-align:center; margin:0; padding:0; }
.small { font-size:14px; }
</style>
</head>
<body>

<h2><b>INVOICE</b></h2>
<hr>

<h3>Your Medical Wholesale Shop Name</h3>
<p class="small">
Address Line 1, City<br>
Phone: 90000 00000<br>
GSTIN: XXXXXXXX
</p>

<hr>

<table>
<tr>
    <td><b>Customer:</b> <?= $invoice['customer_name']; ?></td>
    <td><b>Bill No:</b> <?= $invoice['bill_no']; ?></td>
</tr>
<tr>
    <td><b>Doctor/Hospital:</b> <?= $invoice['doctor_name']; ?></td>
    <td><b>Date:</b> <?= $invoice['date_time']; ?></td>
</tr>
<tr>
    <td><b>Address:</b> <?= nl2br($invoice['address']); ?></td>
    <td><b>GSTIN:</b> <?= $invoice['gstin']; ?></td>
</tr>
</table>

<br>

<table>
<tr>
    <th>Product</th>
    <th>Batch</th>
    <th>Expiry</th>
    <th>HSN</th>
    <th>Qty</th>
    <th>MRP</th>
    <th>Disc%</th>
    <th>GST%</th>
    <th>Amount</th>
</tr>

<?php while($it = $items->fetch_assoc()) { ?>
<tr>
    <td><?= $it['product_name']; ?></td>
    <td><?= $it['batch']; ?></td>
    <td><?= $it['expiry']; ?></td>
    <td><?= $it['hsn']; ?></td>
    <td><?= $it['qty']; ?></td>
    <td><?= number_format($it['mrp'],2); ?></td>
    <td><?= $it['discount_percent']; ?></td>
    <td><?= $it['gst_percent']; ?></td>
    <td><?= number_format($it['amount'],2); ?></td>
</tr>
<?php } ?>

</table>

<br>

<table>
<tr>
    <td><b>Subtotal:</b></td>
    <td><?= number_format($invoice['subtotal'],2); ?></td>
</tr>
<tr>
    <td><b>Discount:</b></td>
    <td><?= $invoice['discount_percent']; ?>%</td>
</tr>
<tr>
    <td><b>GST:</b></td>
    <td><?= $invoice['gst_percent']; ?>%</td>
</tr>
<tr>
    <td><b>Grand Total:</b></td>
    <td><b><?= number_format($invoice['grand_total'],2); ?></b></td>
</tr>
</table>

<br><br>
<p style="text-align:center;">Thank you for your business!</p>

</body>
</html>

<?php
$html = ob_get_clean();

// Create mPDF object
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_top' => 10,
    'margin_bottom' => 10
]);

$mpdf->WriteHTML($html);

// OUTPUT PDF TO BROWSER
$mpdf->Output("Invoice-$id.pdf", "I");
?>

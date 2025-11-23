<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");

// Fetch customers
$customers = $conn->query("SELECT * FROM customers ORDER BY customer_name ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Invoice</title>

<style>
table { width:100%; border-collapse: collapse; }
th, td { border:1px solid #000; padding:6px; text-align:center; }
input, select, textarea { width:100%; padding:5px; }
.btn { padding:10px 20px; background:#007bff; color:#fff; border:none; }
</style>
</head>
<body>

<h2>Create Invoice</h2>

<form action="save_invoice.php" method="POST">

<!-- CUSTOMER DETAILS -->
<label>Customer:</label>
<select name="customer_id" id="customerSelect" required>
    <option value="">-- Select Customer --</option>
    <?php while($c = $customers->fetch_assoc()) { ?>
        <option value="<?= $c['id']; ?>"
            data-name="<?= $c['customer_name']; ?>"
            data-doctor="<?= $c['doctor_name']; ?>"
            data-address="<?= htmlspecialchars($c['address']); ?>"
            data-gstin="<?= $c['gstin']; ?>"
        >
            <?= $c['customer_name']; ?>
        </option>
    <?php } ?>
</select>

<br><br>

<label>Customer Name:</label>
<input type="text" name="customer_name" id="customer_name" readonly>

<label>Doctor/Hospital:</label>
<input type="text" name="doctor_name" id="doctor_name" readonly>

<label>Address:</label>
<textarea name="address" id="address" readonly></textarea>

<label>GSTIN:</label>
<input type="text" name="gstin" id="gstin" readonly>

<br><br>

<label>Bill No:</label>
<input type="text" name="bill_no" required>

<label>Date:</label>
<input type="date" name="date_time" required>

<br><br>

<!-- ITEM TABLE -->
<table id="itemTable">
<tr>
    <th>Product</th>
    <th>Batch</th>
    <th>Expiry</th>
    <th>HSN</th>
    <th>MFG</th>
    <th>Stock</th>
    <th>Qty</th>
    <th>MRP</th>
    <th>Disc%</th>
    <th>GST%</th>
    <th>Amount</th>
    <th>Action</th>
</tr>

<tr>
    <td>
        <select name="product_id[]" class="product-select">
            <option value="">Select Product</option>
            <?php
            $products = $conn->query("SELECT * FROM products ORDER BY product_name ASC");
            while ($p = $products->fetch_assoc()) {
                echo "<option value='{$p['id']}'
                        data-batch='{$p['batch']}'
                        data-expiry='{$p['expiry']}'
                        data-hsn='{$p['hsn']}'
                        data-mfg='{$p['mfg']}'
                        data-mrp='{$p['mrp']}'
                        data-gst='{$p['gst_percent']}'
                        data-qty='{$p['qty']}'
                >
                    {$p['product_name']} [{$p['batch']}]
                </option>";
            }
            ?>
        </select>
    </td>

    <td><input type="text" name="batch[]" class="batch" readonly></td>
    <td><input type="text" name="expiry[]" class="expiry" readonly></td>
    <td><input type="text" name="hsn[]" class="hsn" readonly></td>
    <td><input type="text" name="mfg[]" class="mfg" readonly></td>
    <td><input type="number" name="available_qty[]" class="available_qty" readonly></td>

    <td><input type="number" name="qty[]" class="qty"></td>
    <td><input type="number" name="mrp[]" class="mrp" readonly></td>
    <td><input type="number" name="discount[]" class="discount"></td>
    <td><input type="number" name="gst[]" class="gst" readonly></td>
    <td><input type="number" name="amount[]" class="amount" readonly></td>

    <td><button type="button" onclick="removeRow(this)">X</button></td>
</tr>

</table>

<br>
<button type="button" onclick="addRow()">Add Item</button>

<br><br>

<label>Subtotal:</label>
<input type="text" name="subtotal" id="subtotal" readonly>

<label>Discount %:</label>
<input type="number" name="discount_percent" id="discount_percent">

<label>GST %:</label>
<input type="number" name="gst_percent" id="gst_percent">

<label>Grand Total:</label>
<input type="text" name="grand_total" id="grand_total" readonly>

<br><br>

<button type="submit" class="btn">Save Invoice</button>

</form>

<script>
// -----------------------------
// AUTO-FILL CUSTOMER DETAILS
// -----------------------------
document.getElementById("customerSelect").addEventListener("change", function(){
    let opt = this.selectedOptions[0];

    document.getElementById("customer_name").value = opt.dataset.name;
    document.getElementById("doctor_name").value = opt.dataset.doctor;
    document.getElementById("address").value = opt.dataset.address;
    document.getElementById("gstin").value = opt.dataset.gstin;
});

// -----------------------------
// ADD ROW
// -----------------------------
function addRow() {
    let table = document.getElementById("itemTable");
    let row = table.insertRow(-1);

    row.innerHTML = document.querySelector("#itemTable tr:nth-child(2)").innerHTML;
}

// DELETE ROW
function removeRow(btn) {
    btn.parentElement.parentElement.remove();
}

// -----------------------------
// PRODUCT AUTO-FILL
// -----------------------------
document.addEventListener("change", function(e){
    if (e.target.classList.contains("product-select")) {
        let opt = e.target.selectedOptions[0];
        let row = e.target.closest("tr");

        row.querySelector(".batch").value = opt.dataset.batch;
        row.querySelector(".expiry").value = opt.dataset.expiry;
        row.querySelector(".hsn").value = opt.dataset.hsn;
        row.querySelector(".mfg").value = opt.dataset.mfg;
        row.querySelector(".mrp").value = opt.dataset.mrp;
        row.querySelector(".gst").value = opt.dataset.gst;
        row.querySelector(".available_qty").value = opt.dataset.qty;
    }
});
</script>

</body>
</html>

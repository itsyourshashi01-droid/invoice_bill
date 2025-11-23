<?php
$conn = new mysqli("localhost", "root", "", "medical_billing");
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Purchase Bill</title>
<style>
table { width:100%; border-collapse: collapse; }
td, th { border:1px solid #000; padding:6px; text-align:center; }
input { width:100%; padding:6px; }
.btn { padding:8px 20px; background:#28a745; color:#fff; border:none; cursor:pointer; }
</style>
</head>
<body>

<h2>Add Purchase Bill</h2>

<form action="purchase_save.php" method="POST">

<label>Supplier Name:</label>
<input type="text" name="supplier_name" required>

<label>Bill No:</label>
<input type="text" name="bill_no" required>

<label>Date:</label>
<input type="date" name="date" required>

<br><br>

<table id="purchaseTable">
<tr>
    <th>Product</th>
    <th>Batch</th>
    <th>Expiry</th>
    <th>HSN</th>
    <th>MFG</th>
    <th>MRP</th>
    <th>GST%</th>
    <th>Purchase Rate</th>
    <th>Qty</th>
    <th>Amount</th>
    <th>Action</th>
</tr>

<tr>
    <td><input type="text" name="product_name[]" required></td>
    <td><input type="text" name="batch[]" required></td>
    <td><input type="date" name="expiry[]" required></td>
    <td><input type="text" name="hsn[]"></td>
    <td><input type="text" name="mfg[]"></td>
    <td><input type="number" step="0.01" name="mrp[]" class="mrp"></td>
    <td><input type="number" step="0.01" name="gst_percent[]" class="gst"></td>
    <td><input type="number" step="0.01" name="purchase_rate[]" class="p_rate"></td>
    <td><input type="number" name="qty[]" class="qty"></td>
    <td><input type="number" name="amount[]" class="amount" readonly></td>
    <td><button type="button" onclick="removeRow(this)">X</button></td>
</tr>

</table>

<br>
<button type="button" onclick="addRow()">Add Row</button>

<br><br>

<label>Total Amount:</label>
<input type="text" name="total_amount" id="total_amount" readonly>

<br><br>
<button type="submit" class="btn">Save Purchase</button>

</form>

<script>
function addRow() {
    let table = document.getElementById("purchaseTable");
    let row = table.insertRow(-1);

    row.innerHTML = `
        <td><input type="text" name="product_name[]" required></td>
        <td><input type="text" name="batch[]" required></td>
        <td><input type="date" name="expiry[]" required></td>
        <td><input type="text" name="hsn[]"></td>
        <td><input type="text" name="mfg[]"></td>
        <td><input type="number" step="0.01" name="mrp[]" class="mrp"></td>
        <td><input type="number" step="0.01" name="gst_percent[]" class="gst"></td>
        <td><input type="number" step="0.01" name="purchase_rate[]" class="p_rate"></td>
        <td><input type="number" name="qty[]" class="qty"></td>
        <td><input type="number" name="amount[]" class="amount" readonly></td>
        <td><button type="button" onclick="removeRow(this)">X</button></td>
    `;
}

function removeRow(btn) {
    btn.parentElement.parentElement.remove();
    calcTotal();
}

document.addEventListener("input", function(e){
    if (e.target.classList.contains("qty") ||
        e.target.classList.contains("p_rate")) {

        let row = e.target.closest("tr");
        let qty = parseFloat(row.querySelector(".qty").value) || 0;
        let rate = parseFloat(row.querySelector(".p_rate").value) || 0;

        row.querySelector(".amount").value = (qty * rate).toFixed(2);
        calcTotal();
    }
});

function calcTotal() {
    let total = 0;
    document.querySelectorAll(".amount").forEach(a=>{
        total += parseFloat(a.value) || 0;
    });
    document.getElementById("total_amount").value = total.toFixed(2);
}
</script>

</body>
</html>

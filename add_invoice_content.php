<?php
include "db.php";

// Fetch customers
$customers = $conn->query("SELECT id, customer_name FROM customers ORDER BY customer_name ASC");

// Fetch products (medicine supplier stock)
$products = $conn->query("SELECT id, name, batch_no, mrp FROM supplier_stock ORDER BY name ASC");
?>

<style>
.content-box {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table td, .table th { vertical-align: middle !important; }

button.remove-row {
    border: none;
    background: red;
    color: #fff;
    padding: 4px 10px;
    border-radius: 4px;
}
button.add-row {
    background: #28a745;
    color: white;
    padding: 6px 14px;
    border: none;
    border-radius: 6px;
}
</style>

<div class="content-box">

    <h3>Create Invoice</h3>
    <hr>

    <form id="invoiceForm">

        <!-- CUSTOMER SECTION -->
        <div class="row">
            <div class="col-md-6">
                <label>Customer *</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">Select Customer</option>
                    <?php while($c = $customers->fetch_assoc()) { ?>
                        <option value="<?= $c['id'] ?>"><?= $c['customer_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6">
                <label>Doctor / Hospital</label>
                <input type="text" name="doctor_name" class="form-control">
            </div>
        </div>

        <!-- ITEM TABLE -->
        <h5 class="mt-4">Invoice Items</h5>

        <table class="table table-bordered" id="itemsTable">
            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Batch</th>
                    <th>MRP</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>

            <tbody id="itemBody">

                <tr>
                    <td>
                        <select name="product_id[]" class="form-control productSelect" required>
                            <option value="">Select</option>
                            <?php while($p = $products->fetch_assoc()) { ?>
                                <option 
                                    value="<?= $p['id'] ?>" 
                                    data-batch="<?= $p['batch_no'] ?>"
                                    data-mrp="<?= $p['mrp'] ?>">
                                    <?= $p['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>

                    <td><input type="text" name="batch_no[]" class="form-control batch" readonly></td>
                    <td><input type="text" name="mrp[]" class="form-control mrp" readonly></td>
                    <td><input type="number" name="qty[]" class="form-control qty" min="1" value="1"></td>
                    <td><input type="text" name="total[]" class="form-control total" readonly></td>
                    <td><button type="button" class="remove-row">X</button></td>
                </tr>

            </tbody>
        </table>

        <button type="button" class="add-row mt-2">+ Add Item</button>

        <!-- BILL SUMMARY -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label>Subtotal</label>
                <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
            </div>

            <div class="col-md-4">
                <label>Discount (%)</label>
                <input type="number" id="discount" name="discount" class="form-control" value="0">
            </div>

            <div class="col-md-4">
                <label>GST (%)</label>
                <input type="number" id="gst" name="gst" class="form-control" value="0">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label>Grand Total</label>
                <input type="text" id="grand_total" name="grand_total" class="form-control font-weight-bold" readonly>
            </div>
        </div>

        <!-- SAVE -->
        <button type="submit" class="btn btn-primary mt-4">Save Invoice</button>
        <button type="button" class="btn btn-secondary mt-4 ajax-link" data-page="invoice_list.php">Back</button>

    </form>
</div>

<!-- JAVASCRIPT -->
<script>

function calculateRow(row) {
    let qty = parseFloat(row.find(".qty").val()) || 0;
    let mrp = parseFloat(row.find(".mrp").val()) || 0;
    let total = qty * mrp;

    row.find(".total").val(total.toFixed(2));

    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;

    $(".total").each(function () {
        subtotal += parseFloat($(this).val()) || 0;
    });

    $("#subtotal").val(subtotal.toFixed(2));

    let discount = parseFloat($("#discount").val()) || 0;
    let gst = parseFloat($("#gst").val()) || 0;

    let discounted = subtotal - (subtotal * discount / 100);
    let finalAmount = discounted + (discounted * gst / 100);

    $("#grand_total").val(finalAmount.toFixed(2));
}

/* Change product auto fill batch & price */
$(document).on("change", ".productSelect", function () {
    let row = $(this).closest("tr");
    let selected = $(this).find(":selected");

    row.find(".batch").val(selected.data("batch"));
    row.find(".mrp").val(selected.data("mrp"));

    calculateRow(row);
});

/* Quantity change */
$(document).on("input", ".qty", function () {
    calculateRow($(this).closest("tr"));
});

/* Add new row */
$(".add-row").click(function () {
    let row = $("#itemBody tr:first").clone();
    row.find("input").val("");
    row.find(".qty").val(1);
    $("#itemBody").append(row);
});

/* Remove row */
$(document).on("click", ".remove-row", function () {
    if ($("#itemBody tr").length > 1) {
        $(this).closest("tr").remove();
        calculateTotals();
    }
});

/* Save invoice */
$("#invoiceForm").submit(function (e) {
    e.preventDefault();

    $.post("save_invoice.php", $(this).serialize(), function (response) {
        alert("Invoice Saved Successfully!");
        $("#main-content").load("ajax_page.php?page=invoice_list.php");
    });
});
</script>

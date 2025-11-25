<?php
include "db.php";

$id = $_GET['id'];

$data = $conn->query("
    SELECT * FROM med_supplier WHERE id = $id
")->fetch_assoc();

$suppliers = $conn->query("SELECT * FROM suppliers ORDER BY name ASC");
?>

<div class="content-box">

    <h2>Edit Medicine Supplier Stock</h2>
    <hr>

    <form id="editMedSupplierForm">

        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="row">
            <div class="col-md-6">
                <label>Medicine Code *</label>
                <input type="text" name="medicine_code" class="form-control" required value="<?= $data['medicine_code'] ?>">
            </div>

            <div class="col-md-6">
                <label>Supplier *</label>
                <select name="supplier_id" class="form-control" required>
                    <?php while ($s = $suppliers->fetch_assoc()) { ?>
                        <option value="<?= $s['id'] ?>" 
                            <?= ($s['id'] == $data['supplier_id']) ? "selected" : "" ?>>
                            <?= $s['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Invoice No *</label>
                <input type="text" name="invoice_no" class="form-control" required value="<?= $data['invoice_no'] ?>">
            </div>

            <div class="col-md-6">
                <label>Total Qty *</label>
                <input type="number" name="total_qty" class="form-control" required value="<?= $data['total_qty'] ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Free Qty</label>
                <input type="number" name="free_qty" class="form-control" value="<?= $data['free_qty'] ?>">
            </div>

            <div class="col-md-6">
                <label>Total Rate *</label>
                <input type="number" step="0.01" name="total_rate" class="form-control" required value="<?= $data['total_rate'] ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Total MRP *</label>
                <input type="number" step="0.01" name="total_mrp" class="form-control" required value="<?= $data['total_mrp'] ?>">
            </div>

            <div class="col-md-6">
                <label>Discount %</label>
                <input type="number" step="0.01" name="discount_percent" class="form-control" value="<?= $data['discount_percent'] ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>GST %</label>
                <input type="number" step="0.01" name="gst_percent" class="form-control" value="<?= $data['gst_percent'] ?>">
            </div>

            <div class="col-md-6">
                <label>Subtotal *</label>
                <input type="number" step="0.01" name="subtotal" class="form-control" required value="<?= $data['subtotal'] ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-4">Update</button>
        <button type="button" class="btn btn-secondary mt-4 ajax-link" data-page="supplier_stock_content.php">Back</button>
    </form>

</div>

<script>
$("#editMedSupplierForm").submit(function(e){
    e.preventDefault();

    $.post("edit_med_supplier_save.php", $(this).serialize(), function (res) {
        alert("Updated Successfully");
        $("#main-content").load("ajax_page.php?page=supplier_stock_content.php");
    });
});
</script>

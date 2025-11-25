<div class="modal-box">

    <h2 class="title">Add Medicine Supplier Stock</h2>
    <hr>

    <form id="medSupplierForm">

        <div class="form-row">
            <div class="form-group">
                <label>Medicine Code *</label>
                <input type="text" name="medicine_code" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Supplier *</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">Select Supplier</option>
                    <?php
                    $sup = $conn->query("SELECT id,name FROM suppliers ORDER BY name ASC");
                    while($s = $sup->fetch_assoc()){ ?>
                        <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Invoice No *</label>
                <input type="text" name="invoice_no" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Total Qty *</label>
                <input type="number" name="total_qty" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Free Qty</label>
                <input type="number" name="free_qty" class="form-control" value="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Total Rate *</label>
                <input type="number" step="0.01" name="total_rate" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Total MRP *</label>
                <input type="number" step="0.01" name="total_mrp" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Discount %</label>
                <input type="number" step="0.01" name="discount_percent" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label>GST %</label>
                <input type="number" step="0.01" name="gst_percent" class="form-control" value="0">
            </div>

            <div class="form-group">
                <label>Subtotal *</label>
                <input type="number" step="0.01" name="subtotal" class="form-control" required>
            </div>
        </div>

        <div class="button-row">
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary ajax-link" data-page="supplier_stock_content.php">Back</button>
        </div>

    </form>

</div>


<style>
.modal-box {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.title {
    font-size: 26px;
    font-weight: 700;
}
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}
.form-group {
    flex: 1;
}
.button-row {
    margin-top: 25px;
    display: flex;
    gap: 10px;
}
</style>


<script>
$("#medSupplierForm").submit(function(e){
    e.preventDefault();

    $.post("add_med_supplier_save.php", $(this).serialize(), function(res){
        alert("Medicine Supplier Stock Added Successfully");
        $("#main-content").load("ajax_page.php?page=supplier_stock_content.php");
    });
});
</script>

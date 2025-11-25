<?php
require_once "db.php";

$id = $_GET['id'] ?? 0;
if ($id == 0) {
    echo "<h4>Invalid Supplier ID</h4>";
    exit;
}

$q = $conn->query("SELECT * FROM suppliers WHERE id = $id");
$data = $q->fetch_assoc();
?>

<div class="card">
    <div class="card-header">
        <h4>Edit Supplier</h4>
    </div>

    <div class="card-body">
        <form id="editSupplierForm">

            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <label>Supplier Name *</label>
            <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" required>

            <label>Contact Person</label>
            <input type="text" name="contact_person" value="<?= $data['contact_person'] ?>" class="form-control">

            <label>Phone</label>
            <input type="text" name="phone" value="<?= $data['phone'] ?>" class="form-control">

            <label>Email</label>
            <input type="text" name="email" value="<?= $data['email'] ?>" class="form-control">

            <label>Address</label>
            <textarea name="address" class="form-control"><?= $data['address'] ?></textarea>

            <label>GST No</label>
            <input type="text" name="gst_no" value="<?= $data['gst_no'] ?>" class="form-control">

            <label>PAN No</label>
            <input type="text" name="pan_no" value="<?= $data['pan_no'] ?>" class="form-control">

            <label>DL Number</label>
            <input type="text" name="dl_no" value="<?= $data['dl_no'] ?>" class="form-control">

            <label>FL Number</label>
            <input type="text" name="fl_no" value="<?= $data['fl_no'] ?>" class="form-control">

            <label>Chalan Number</label>
            <input type="text" name="chalan_no" value="<?= $data['chalan_no'] ?>" class="form-control">

            <button class="btn btn-success mt-3">Update</button>
            <button type="button" class="btn btn-secondary mt-3 ajax-link" data-page="suppliers_content.php">Back</button>

        </form>
    </div>
</div>

<script>
$("#editSupplierForm").submit(function(e){
    e.preventDefault();

    $.post("supplier_save.php", $(this).serialize(), function (res) {
        alert("Supplier Updated Successfully");
        $("#main-content").load("ajax_page.php?page=suppliers_content.php");
    });
});
</script>

<div class="form-wrapper">

    <div class="form-card">
        <h2 class="title">Add New Supplier</h2>
        <hr>

        <form id="supplierForm">

            <div class="row">
                <div class="col-md-6">
                    <label>Supplier Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" class="form-control">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
            </div>

            <div class="mt-3">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>GST No</label>
                    <input type="text" name="gst_no" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>PAN No</label>
                    <input type="text" name="pan_no" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Chalan Number</label>
                    <input type="text" name="chalan_no" class="form-control">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>DL Number</label>
                    <input type="text" name="dl_number" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>FL Number</label>
                    <input type="text" name="fl_number" class="form-control">
                </div>
            </div>

            <div class="btn-row mt-4">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary ajax-link" data-page="suppliers_content.php">Back</button>
            </div>

        </form>
    </div>
</div>

<style>
.form-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 20px;
}

.form-card {
    width: 80%;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 3px 12px rgba(0,0,0,0.15);
}

.title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #1e3a8a;
}

.req { color: red; }

.btn-row {
    display: flex;
    gap: 15px;
}
</style>

<script>
$("#supplierForm").submit(function(e){
    e.preventDefault();

    $.post("supplier_add_ajax.php", $(this).serialize(), function (res) {
        alert("Supplier Added Successfully");
        $("#main-content").load("ajax_page.php?page=suppliers_content.php");
    });
});
</script>

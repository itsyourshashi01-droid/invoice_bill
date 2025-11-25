<?php include("db.php"); ?>
<div class="content-box">

    <h2>Add New Customer</h2>
    <hr>

    <form id="customerForm">

        <div class="row">
            <div class="col-md-6">
                <label><strong>Customer Name *</strong></label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label><strong>Contact</strong></label>
                <input type="text" name="contact" class="form-control">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label><strong>GSTIN</strong></label>
                <input type="text" name="gstin" class="form-control">
            </div>

            <div class="col-md-6">
                <label><strong>Doctor / Hospital</strong></label>
                <input type="text" name="doctor_name" class="form-control">
            </div>
        </div>

        <div class="mt-3">
            <label><strong>Address</strong></label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-4">Save Customer</button>

        <button type="button" 
                class="btn btn-secondary mt-4 ajax-link" 
                data-page="customers_list.php">
            Back
        </button>

    </form>

</div>

<script>
$("#customerForm").submit(function(e){
    e.preventDefault();

    $.post("customer_add_ajax.php", $(this).serialize(), function(res){
        alert("Customer Added Successfully");
        $("#main-content").load("ajax_page.php?page=customers_list.php");
    });
});
</script>

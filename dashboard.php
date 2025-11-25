<?php
include "db.php";

// SAFE COUNTS WITH ERROR CHECKING
function safeCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = $conn->query($sql);

    if (!$result) { return 0; }

    $row = $result->fetch_assoc();
    return $row['total'];
}

// Correct table names based on your phpMyAdmin screenshot
$total_products   = safeCount($conn, "smh_stock");      // Medicine Stock (SMH)
$total_customers  = safeCount($conn, "customers");
$total_invoices   = safeCount($conn, "invoices");
$total_purchases  = safeCount($conn, "purchases");
?>

<div class="page-title">Dashboard</div>

<div class="dash-box-container">

    <div class="dash-box" onclick="loadPage('customers')">
        <div class="dash-box-number"><?= $total_customers ?></div>
        <div class="dash-box-label">Total Customers</div>
    </div>

    <div class="dash-box" onclick="loadPage('supplier_stock')">
        <div class="dash-box-number"><?= $total_products ?></div>
        <div class="dash-box-label">Medicine Stock</div>
    </div>

    <div class="dash-box" onclick="loadPage('invoices')">
        <div class="dash-box-number"><?= $total_invoices ?></div>
        <div class="dash-box-label">Total Invoices</div>
    </div>

    <div class="dash-box" onclick="loadPage('purchase_list')">
        <div class="dash-box-number"><?= $total_purchases ?></div>
        <div class="dash-box-label">Total Purchases</div>
    </div>

</div>

<style>
.page-title {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Dashboard Boxes */
.dash-box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.dash-box {
    width: 260px;
    padding: 25px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0px 2px 6px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: 0.25s;
}

.dash-box:hover {
    background: #f0f6ff;
    transform: translateY(-3px);
}

.dash-box-number {
    font-size: 42px;
    font-weight: bold;
    color: #1b5fc9;
}

.dash-box-label {
    font-size: 18px;
    color: #333;
}

/* Mobile Responsive */
@media(max-width: 600px){
    .dash-box {
        width: 100%;
    }
}
</style>

<script>
// AJAX Page Loader
function loadPage(pageName){
    $("#content-area").load("ajax_page.php?page=" + pageName);
}
</script>

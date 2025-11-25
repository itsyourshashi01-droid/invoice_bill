<?php
// ajax_page.php
// SAFE PAGE LOADER

// Allowed pages (add more if needed)
$allowed_pages = [
    "dashboard_content.php",
    "medical_profile_content.php",
    "suppliers_content.php",
    "supplier_stock_content.php",
    "customers_content.php",
    "invoice_list.php",
    "products_list.php",
    "add_invoice_content.php",
    "customers_add.php",
    "supplier_add.php",
    "supplier_stock_content.php"
];

// Get requested page
$page = isset($_GET['page']) ? basename($_GET['page']) : "";

// Validate
if (!$page || !in_array($page, $allowed_pages)) {
    echo "<div class='card'>
            <div class='card-body'>
                <h3>Page not found</h3>
                <p>Requested page not available: <b>$page</b></p>
            </div>
          </div>";
    exit;
}

$filepath = __DIR__ . "/" . $page;

if (file_exists($filepath)) {
    include $filepath;
} else {
    echo "<div class='card'>
            <div class='card-body'>
                <h3>File missing</h3>
                <p>The requested file does not exist on server: <b>$page</b></p>
            </div>
          </div>";
}
?>

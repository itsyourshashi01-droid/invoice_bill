<?php
// layout.php — Main Layout for All Pages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MedicalAPP</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f1f5f9;
            font-family: "Segoe UI", sans-serif;
        }

        /* Sidebar */
        #sidebar {
            width: 250px;
            height: 100vh;
            background: #1e293b; /* Microsoft dark mode */
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 15px;
        }

        #sidebar .logo {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        #sidebar .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #sidebar .menu li {
            margin: 15px 0;
        }

        #sidebar .menu a {
            color: #dbe2ef;
            padding: 10px;
            display: block;
            border-radius: 6px;
            transition: 0.2s;
            font-size: 16px;
        }

        #sidebar .menu a i {
            width: 25px;
        }

        #sidebar .menu a:hover,
        #sidebar .menu a.active {
            background: #334155;
            color: #fff;
        }

        /* MAIN CONTENT */
        #main-content {
            margin-left: 260px;
            padding: 25px;
            min-height: 100vh;
            background: #f8fafc;
        }
    </style>

</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">

    <h2 class="logo">MedicalAPP<br><small>Wholesale</small></h2>

    <ul class="menu">

    <li><a href="#" class="ajax-link" data-page="dashboard_content.php">
        <i class="fas fa-home"></i> Dashboard
    </a></li>

    <li><a href="#" class="ajax-link" data-page="medical_profile_content.php">
        <i class="fas fa-user-cog"></i> Manage Profile
    </a></li>

    <li><a href="#" class="ajax-link" data-page="suppliers_content.php">
        <i class="fas fa-truck"></i> Surgical Suppliers
    </a></li>

    <li><a href="#" class="ajax-link" data-page="supplier_stock_content.php">
        <i class="fas fa-boxes"></i> Medicine Suppliers
    </a></li>

    <li><a href="#" class="ajax-link" data-page="customers_content.php">
        <i class="fas fa-users"></i> Customers
    </a></li>

    <li><a href="#" class="ajax-link" data-page="invoice_list.php">
        <i class="fas fa-file-invoice"></i> Invoices
    </a></li>

</ul>


</div>

<!-- MAIN CONTENT -->
<div id="main-content">
    <!-- Loaded dynamically via AJAX -->
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){

    // Load default dashboard
    $("#main-content").load("ajax_page.php?page=dashboard_content.php");

    // Sidebar AJAX Navigation
    $(document).on("click", ".ajax-link", function(e){
        e.preventDefault();

        // Remove previous active
        $(".ajax-link").removeClass("active");

        // Add active class
        $(this).addClass("active");

        let page = $(this).data("page");

        $("#main-content").load(
            "ajax_page.php?page=" + page,
            function(response, status) {
                if (status === "error") {
                    $("#main-content").html("<h3 class='text-danger'>Error loading page.</h3>");
                }
            }
        );
    });

});
</script>

</body>
</html>

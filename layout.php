<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MedicalAPP - Simple</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables Buttons (for Excel and Print) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <nav class="bg-dark text-white p-3" style="width:240px; height:100vh;">
    <h5>MedicalAPP</h5>
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link text-white" href="index.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="medical_profile.php">Manage Profile</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="suppliers.php">Suppliers List</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="supplier_stock.php">Supplier Medicine Stocks</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="smh_stock.php">SMH Medicine Stocks</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="invoice_list.php">Medicine Invoice</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="add_invoice.php">Add New Invoice</a></li>
    </ul>
  </nav>

  <!-- Main -->
  <div class="flex-fill p-4">
    <?php include($page); ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/script.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
</body>
</html>

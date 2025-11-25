<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body { background:#f5f5f5; }

        .card {
            border-radius: 12px;
            border: none;
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
        }

        thead {
            background: #1f1f1f;
            color: white;
        }

        .btn-primary {
            background: #0078d4;
            border:none;
            border-radius:6px;
        }

        .btn-primary:hover {
            background:#005fa3;
        }

        .filter-box label {
            font-weight:600;
            margin-right:5px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Customers</h3>
        <a class="nav-link ajax-link text-white" data-page="customers_add.php">Add Customer</a>
    </div>

    <!-- Filters -->
    <div class="card p-3 mb-3">
        <div class="row filter-box">

            <div class="col-md-4">
                <label>Search:</label>
                <input type="text" id="searchBox" class="form-control" placeholder="Name, Address, Phone">
            </div>

            <div class="col-md-3">
                <label>City:</label>
                <input type="text" id="cityFilter" class="form-control" placeholder="Filter by City">
            </div>

            <div class="col-md-3">
                <label>State:</label>
                <input type="text" id="stateFilter" class="form-control" placeholder="Filter by State">
            </div>

        </div>
    </div>

    <div class="card p-3">
        <table id="customerTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Type</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM customers ORDER BY id DESC";
                $res = $conn->query($sql);
                while ($row = $res->fetch_assoc()) {

                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['state']}</td>
                        <td>{$row['address']}</td>

                        <td>
                            <a href='customer_edit.php?id={$row['id']}' class='btn btn-sm btn-info'>Edit</a>
                            <a href='customer_delete.php?id={$row['id']}' 
                               class='btn btn-sm btn-danger'
                               onclick=\"return confirm('Delete customer?');\">
                               Delete
                            </a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    var table = $('#customerTable').DataTable();

    // Search box
    $('#searchBox').keyup(function(){
        table.search($(this).val()).draw();
    });

    // City filter
    $('#cityFilter').keyup(function(){
        table.column(5).search($(this).val()).draw();
    });

    // State filter
    $('#stateFilter').keyup(function(){
        table.column(6).search($(this).val()).draw();
    });

});
</script>

</body>
</html>

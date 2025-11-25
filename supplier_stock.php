<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medicine Supplier</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body { background:#f5f5f5; }

        .card {
            border-radius: 10px;
            border: none;
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: #0078d4;
            border: none;
        }

        .btn-primary:hover {
            background: #005fa3;
        }

        table thead {
            background: #1f1f1f;
            color: white;
        }
    </style>
</head>

<body>
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Medicine Supplier</h3>
        <a href="supplier_add.php" class="btn btn-primary">Add Supplier</a>
    </div>

    <div class="card p-3">
        <table id="stockTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Medicine Code</th>
                    <th>Supplier</th>
                    <th>Invoice No</th>
                    <th>Total Qty</th>
                    <th>MRP</th>
                    <th>Rate</th>
                    <th>Discount %</th>
                    <th>GST %</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $q = "
                    SELECT s.*, sup.name AS supplier_name 
                    FROM supplier_stock s
                    LEFT JOIN suppliers sup ON s.supplier_id = sup.id
                    ORDER BY s.id DESC
                ";
                $result = $conn->query($q);

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['medicine_code']}</td>
                        <td>{$row['supplier_name']}</td>
                        <td>{$row['invoice_no']}</td>
                        <td>{$row['qty']}</td>
                        <td>{$row['mrp']}</td>
                        <td>{$row['rate']}</td>
                        <td>{$row['discount_percent']}</td>
                        <td>{$row['gst_percent']}</td>
                        <td>{$row['subtotal']}</td>

                        <td>
                            <a href='stock_view.php?id={$row['id']}' class='btn btn-sm btn-info'>View</a>
                            <a href='stock_delete.php?id={$row['id']}' 
                               class='btn btn-sm btn-danger'
                               onclick=\"return confirm('Delete this stock entry?');\">
                               Delete
                            </a>
                        </td>
                    </tr>";
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
    $('#stockTable').DataTable({
        "pageLength": 10,
        "order": [[0, "desc"]]
    });
});
</script>

</body>
</html>

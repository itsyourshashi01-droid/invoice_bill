<?php
include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoices</title>

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

        .btn-success {
            border-radius: 6px;
        }

        .filter-label {
            font-weight:600;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Invoices</h3>
        <a href="add_invoice.php" class="btn btn-primary">+ Add New Invoice</a>
    </div>

    <!-- FILTERS -->
    <div class="card p-3 mb-3">
        <form id="filterForm">

            <div class="form-row">

                <!-- Customer Filter -->
                <div class="col-md-3">
                    <label class="filter-label">Customer</label>
                    <input type="text" id="customerFilter" class="form-control" placeholder="Customer Name">
                </div>

                <!-- Bill No Filter -->
                <div class="col-md-3">
                    <label class="filter-label">Bill No</label>
                    <input type="text" id="billFilter" class="form-control" placeholder="Search Bill No">
                </div>

                <!-- Date From -->
                <div class="col-md-3">
                    <label class="filter-label">From Date</label>
                    <input type="date" id="fromDate" class="form-control">
                </div>

                <!-- Date To -->
                <div class="col-md-3">
                    <label class="filter-label">To Date</label>
                    <input type="date" id="toDate" class="form-control">
                </div>

            </div>
        </form>
    </div>

    <div class="card p-3">

        <table id="invoiceTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bill No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Doctor/Hospital</th>
                    <th>Subtotal</th>
                    <th>Discount %</th>
                    <th>GST %</th>
                    <th>Grand Total</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $query = "SELECT * FROM invoices ORDER BY id DESC";
            $res = $conn->query($query);
            while ($inv = $res->fetch_assoc()) {

                echo "
                <tr>
                    <td>{$inv['id']}</td>
                    <td>{$inv['bill_no']}</td>
                    <td>{$inv['date_time']}</td>
                    <td>{$inv['customer_name']}</td>
                    <td>{$inv['doctor_name']}</td>
                    <td>".number_format($inv['subtotal'],2)."</td>
                    <td>{$inv['discount_percent']}%</td>
                    <td>{$inv['gst_percent']}%</td>
                    <td><b>".number_format($inv['grand_total'],2)."</b></td>

                    <td>
                        <a href='invoice_print.php?id={$inv['id']}' class='btn btn-sm btn-success'>Print</a>
                        <a href='invoice_pdf.php?id={$inv['id']}' class='btn btn-sm btn-primary'>PDF</a>
                        <a href='invoice_delete.php?id={$inv['id']}' 
                           class='btn btn-sm btn-danger'
                           onclick=\"return confirm('Delete this invoice? Stock will be restored.');\">
                           Delete
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>

        <hr>

        <h4>Total Sales: ₹ <span id="totalSales"></span></h4>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    var table = $('#invoiceTable').DataTable({
        "pageLength": 10,
        "order": [[0, "desc"]]
    });

    // Calculate total sales
    function updateTotalSales() {
        var total = 0;
        table.rows({ filter: 'applied' }).every(function () {
            total += parseFloat(this.data()[8]); // grand_total column index
        });
        $('#totalSales').text(total.toFixed(2));
    }

    updateTotalSales();

    // Filters
    $('#customerFilter').keyup(function () {
        table.column(3).search(this.value).draw();
        updateTotalSales();
    });

    $('#billFilter').keyup(function () {
        table.column(1).search(this.value).draw();
        updateTotalSales();
    });

    $('#fromDate, #toDate').change(function () {
        var from = $('#fromDate').val();
        var to = $('#toDate').val();

        table.draw();

        updateTotalSales();
    });

});
</script>

</body>
</html>

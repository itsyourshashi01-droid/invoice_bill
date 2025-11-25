<?php
include "db.php";

$res = $conn->query("
    SELECT m.*, s.name AS supplier_name 
    FROM med_supplier m 
    LEFT JOIN suppliers s ON m.supplier_id = s.id
    ORDER BY m.id DESC
");
?>

<div class="content-box">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Medicine Supplier Stock</h2>
        <div>
            <button class="btn btn-primary ajax-link" data-page="add_med_supplier.php">Add Med Supplier</button>
            <button class="btn btn-success" onclick="exportTable()">Export Excel</button>
            <button class="btn btn-info" onclick="window.print()">Print</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-striped table-bordered table-sm" id="medStockTable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Medicine Code</th>
                        <th>Supplier</th>
                        <th>Invoice No</th>
                        <th>Total Qty</th>
                        <th>Free Qty</th>
                        <th>Total Rate</th>
                        <th>Total MRP</th>
                        <th>Discount %</th>
                        <th>GST %</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $res->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['medicine_code'] ?></td>
                            <td><?= $row['supplier_name'] ?></td>
                            <td><?= $row['invoice_no'] ?></td>
                            <td><?= $row['total_qty'] ?></td>
                            <td><?= $row['free_qty'] ?></td>
                            <td><?= $row['total_rate'] ?></td>
                            <td><?= $row['total_mrp'] ?></td>
                            <td><?= $row['discount_percent'] ?></td>
                            <td><?= $row['gst_percent'] ?></td>
                            <td><?= $row['subtotal'] ?></td>

                            <td>
                                <button class="btn btn-info btn-sm ajax-link"
                                    data-page="view_med_supplier.php?id=<?= $row['id'] ?>">View</button>

                                <button class="btn btn-warning btn-sm ajax-link"
                                    data-page="edit_med_supplier.php?id=<?= $row['id'] ?>">Edit</button>

                                <a href="delete_med_supplier.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Delete this entry?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<script>
$(document).ready(function () {
    $('#medStockTable').DataTable({
        "pageLength": 10,
        "order": [[0, "DESC"]]
    });
});
</script>

<script>
function exportTable() {
    alert("Excel Export Coming Soon!");
}
</script>

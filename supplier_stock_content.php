<?php
$conn = new mysqli("localhost","root","","medical_billing");
$res = $conn->query("SELECT s.*, sp.name AS supplier_name FROM supplier_stock s LEFT JOIN suppliers sp ON s.supplier_id=sp.id ORDER BY s.id DESC");
?>
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Supplier Medicine Stock Management</h5>
    <div>
      <a href="supplier_stock_add.php" class="btn btn-primary">+ Add New Medicine</a>
      <button class="btn btn-success" onclick="exportTable()">Export Excel</button>
      <button class="btn btn-info" onclick="window.print()">Print</button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <th>S.No</th><th>Medicine Code</th><th>Supplier</th><th>Invoice No</th><th>Total Qty + Free</th><th>Total Rate</th><th>Total MRP</th><th>Discount %</th><th>GST %</th><th>Subtotal</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while($r = $res->fetch_assoc()){ ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $r['medicine_code'] ?></td>
          <td><?= $r['supplier_name'] ?></td>
          <td><?= $r['invoice_no'] ?></td>
          <td><?= $r['total_qty'] ?> + <?= $r['free_qty'] ?></td>
          <td><?= $r['total_rate'] ?></td>
          <td><?= $r['total_mrp'] ?></td>
          <td><?= $r['discount_percent'] ?? $r['discount'] ?>%</td>
          <td><?= $r['gst_percent'] ?? $r['gst'] ?>%</td>
          <td><?= $r['subtotal'] ?></td>
          <td>
            <a class="btn btn-info btn-sm" href="supplier_stock_view.php?id=<?= $r['id'] ?>">View</a>
            <a class="btn btn-danger btn-sm" href="supplier_stock_delete.php?id=<?= $r['id'] ?>">Delete</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

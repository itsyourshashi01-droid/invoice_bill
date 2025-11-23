<?php
$conn = new mysqli("localhost","root","","medical_billing");
$res = $conn->query("SELECT * FROM suppliers ORDER BY id DESC");
?>
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Supplier Management List</h5>
    <a href="supplier_add.php" class="btn btn-primary">+ Add New Supplier</a>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Contact Person</th><th>Phone</th><th>Email</th><th>Address</th><th>GST No</th><th>PAN No</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['name'] ?></td>
            <td><?= $r['contact_person'] ?></td>
            <td><?= $r['phone'] ?></td>
            <td><?= $r['email'] ?></td>
            <td><?= $r['address'] ?></td>
            <td><?= $r['gst_no'] ?></td>
            <td><?= $r['pan_no'] ?></td>
            <td>
              <a href="supplier_edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="supplier_delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

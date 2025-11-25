<?php
require_once(__DIR__ . "/config.php");

$query = "SELECT * FROM suppliers ORDER BY id DESC";
$res = $conn->query($query);
?>

<div class="content-box">

    <div class="d-flex justify-content-between mb-3">
        <h2>Surgical Supplier List</h2>
        <button class="btn btn-primary ajax-link" data-page="supplier_add.php">+ Add New Supplier</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>GST No</th>
                <th>PAN No</th>
                <th>DL No</th>
                <th>FL No</th>
                <th>Chalan No</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $res->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['contact_person'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['gst_no'] ?></td>
                <td><?= $row['pan_no'] ?></td>
                <td><?= $row['dl_no'] ?></td>
                <td><?= $row['fl_no'] ?></td>
                <td><?= $row['chalan_no'] ?></td>

                <td>
                    <button class="btn btn-warning btn-sm ajax-link" data-page="supplier_edit.php?id=<?= $row['id'] ?>">Edit</button>
                    <button class="btn btn-danger btn-sm delete-supplier" data-id="<?= $row['id'] ?>">Delete</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script>
$(".delete-supplier").click(function () {
    let id = $(this).data("id");

    if (confirm("Are you sure you want to delete this supplier?")) {
        $.post("supplier_delete_ajax.php", { id }, function (res) {
            alert("Supplier Deleted!");
            $("#main-content").load("ajax_page.php?page=suppliers_content.php");
        });
    }
});
</script>

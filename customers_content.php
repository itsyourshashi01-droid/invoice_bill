<?php
include("db.php");

$res = $conn->query("SELECT * FROM customers ORDER BY id DESC");
?>

<div class="card">
    
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Customer List</h5>

        <a class="btn btn-success ajax-link" data-page="customers_add.php">
            + Add New Customer
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>GSTIN</th>
                    <th>Doctor / Hospital</th>
                    <th>Address</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php while($c = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['customer_name'] ?></td>
                    <td><?= $c['contact'] ?></td>
                    <td><?= $c['gstin'] ?></td>
                    <td><?= $c['doctor_name'] ?></td>
                    <td><?= $c['address'] ?></td>
                    <td><?= date('d-m-Y', strtotime($c['created_on'])) ?></td>

                    <td>

                        <!-- View Customer -->
                        <button 
                            class="btn btn-info btn-sm ajax-link"
                            data-page="customer_view.php?id=<?= $c['id'] ?>">
                            View
                        </button>

                        <!-- Edit -->
                        <button 
                            class="btn btn-warning btn-sm ajax-link"
                            data-page="customers_edit.php?id=<?= $c['id'] ?>">
                            Edit
                        </button>

                        <!-- Delete -->
                        <a 
                            href="customers_delete.php?id=<?= $c['id'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this customer?');">
                            Delete
                        </a>

                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

</div>

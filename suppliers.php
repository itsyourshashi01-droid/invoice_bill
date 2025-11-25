<?php
include "db.php";

// Fetch suppliers
$result = $conn->query("SELECT * FROM suppliers ORDER BY id DESC");
?>

<div class="page-title">Surgical Suppliers</div>

<div class="top-actions">
    <button class="btn btn-green" onclick="loadPage('supplier_add')">
        + Add New Supplier
    </button>
</div>

<div class="table-card">
    <table class="modern-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Supplier Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Email</th>
                <th>GST No</th>
                <th>PAN No</th>
                <th>Address</th>
                <th style="width: 140px;">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['contact_person'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['gst_no'] ?></td>
                    <td><?= $row['pan_no'] ?></td>
                    <td><?= $row['address'] ?></td>

                    <td>
                        <button onclick="loadPage('supplier_edit&id=<?= $row['id'] ?>')" class="btn btn-blue btn-sm">
                            Edit
                        </button>
                        <button class="btn btn-red btn-sm" onclick="deleteSupplier(<?= $row['id'] ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function deleteSupplier(id){
    if(confirm("Delete this supplier?")){
        $.post("supplier_delete.php", { id:id }, function(){
            loadPage("suppliers");
        });
    }
}
</script>


<style>
.page-title {
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 14px;
}

.top-actions {
    margin-bottom: 12px;
}

/* Table Card */
.table-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* Modern Table */
.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    background: #102542;      /* Navy Blue */
    color: white;
    padding: 10px;
    text-align: left;
    font-size: 14px;
}

.modern-table td {
    padding: 10px;
    border-bottom: 1px solid #ececec;
    font-size: 14px;
}

.modern-table tr:hover {
    background: #f3f8ff;
}

/* Buttons */
.btn {
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 14px;
    color: white;
}

.btn-green { background: #28a745; }
.btn-blue  { background: #1572ff; }
.btn-red   { background: #dc3545; }

.btn-sm {
    padding: 6px 10px;
    font-size: 12px;
}

/* Mobile Responsive */
@media(max-width: 768px) {

    .modern-table th,
    .modern-table td {
        font-size: 12px;
        padding: 6px;
    }

    .btn-sm {
        font-size: 11px;
        padding: 5px 8px;
    }

    .table-card {
        padding: 12px;
    }
}
</style>

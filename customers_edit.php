<?php
include("db.php");

// GET CUSTOMER DATA
if (!isset($_GET['id'])) {
    die("Customer ID missing!");
}

$id = $_GET['id'];

$q = "SELECT * FROM customers WHERE id = $id";
$res = $conn->query($q);

if ($res->num_rows == 0) {
    die("Customer not found!");
}

$data = $res->fetch_assoc();

// UPDATE CUSTOMER
if (isset($_POST['update'])) {

    $type       = $_POST['type'];
    $name       = $_POST['customer_name'];
    $contact    = $_POST['contact'];
    $email      = $_POST['email'];
    $gstin      = $_POST['gstin'];
    $city       = $_POST['city'];
    $state      = $_POST['state'];
    $pincode    = $_POST['pincode'];
    $address    = $_POST['address'];
    $doctor     = $_POST['doctor_name'];

    $sql = "UPDATE customers SET 
                type='$type',
                customer_name='$name',
                contact='$contact',
                email='$email',
                gstin='$gstin',
                city='$city',
                state='$state',
                pincode='$pincode',
                address='$address',
                doctor_name='$doctor'
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: customers.php?updated=1");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Failed to update customer!</div>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI';
        }

        .card {
            border-radius: 12px;
            border: none;
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
        }

        h3 {
            font-weight: 700;
        }

        .btn-primary {
            background: #0078d4;
            border: none;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background: #005fa3;
        }

        .btn-secondary {
            border-radius: 6px;
        }

        label {
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Edit Customer</h3>
        <a href="customers.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="card p-4">

        <form method="POST">

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label>Customer Type</label>
                    <select name="type" class="form-control" required>
                        <option <?= ($data['type']=="Hospital") ? "selected":"" ?>>Hospital</option>
                        <option <?= ($data['type']=="Clinic") ? "selected":"" ?>>Clinic</option>
                        <option <?= ($data['type']=="Medical Shop") ? "selected":"" ?>>Medical Shop</option>
                        <option <?= ($data['type']=="Doctor") ? "selected":"" ?>>Doctor</option>
                    </select>
                </div>

                <div class="form-group col-md-8">
                    <label>Customer / Hospital / Shop Name</label>
                    <input type="text" name="customer_name" value="<?= $data['customer_name'] ?>" class="form-control" required>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label>Phone</label>
                    <input type="text" name="contact" value="<?= $data['contact'] ?>" class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label>GSTIN</label>
                    <input type="text" name="gstin" value="<?= $data['gstin'] ?>" class="form-control">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label>City</label>
                    <input type="text" name="city" value="<?= $data['city'] ?>" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label>State</label>
                    <input type="text" name="state" value="<?= $data['state'] ?>" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label>Pincode</label>
                    <input type="text" name="pincode" value="<?= $data['pincode'] ?>" class="form-control">
                </div>

            </div>

            <div class="form-group">
                <label>Full Address</label>
                <textarea name="address" rows="3" class="form-control"><?= $data['address'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Doctor Name (optional)</label>
                <input type="text" name="doctor_name" value="<?= $data['doctor_name'] ?>" class="form-control">
            </div>

            <button type="submit" name="update" class="btn btn-primary btn-lg">Update Customer</button>

        </form>

    </div>

</div>

</body>
</html>

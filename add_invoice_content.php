<?php
$conn = new mysqli("localhost","root","","medical_billing");
$suppliers = $conn->query("SELECT * FROM suppliers ORDER BY name");
?>
<div class="card">
  <div class="card-header"><h5>Add New Invoice</h5></div>
  <div class="card-body">
    <form method="POST" action="save_invoice.php">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Bill No (auto)</label>
          <input type="text" class="form-control" name="bill_no" value="SM<?=rand(100000,999999)?>" readonly>
        </div>
        <div class="form-group col-md-4">
          <label>Customer (Doctor/Hospital/Shop)</label>
          <select name="supplier_id" class="form-control" required>
            <option value="">-- Select --</option>
            <?php while($s = $suppliers->fetch_assoc()){ ?>
              <option value="<?= $s['id'] ?>"><?= $s['name'] ?> (<?= $s['contact_person'] ?>)</option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label>Reg No / Doctor</label>
          <input type="text" name="reg_no" class="form-control" placeholder="Registration / Doctor">
        </div>
      </div>

      <h6>Items</h6>
      <table class="table table-sm" id="itemsTable">
        <thead>
          <tr><th>Product</th><th>Qty</th><th>MRP</th><th>Discount %</th><th>GST %</th><th>Amount</th><th></th></tr>
        </thead>
        <tbody>
          <tr>
            <td><input name="product_name[]" class="form-control" required></td>
            <td><input name="qty[]" class="form-control qty" value="1" type="number" step="0.01" required></td>
            <td><input name="mrp[]" class="form-control mrp" type="number" step="0.01" required></td>
            <td><input name="discount[]" class="form-control discount" type="number" step="0.01" value="0"></td>
            <td><input name="gst[]" class="form-control gst" type="number" step="0.01" value="0"></td>
            <td class="amount-cell">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-secondary" id="addRow">Add Item</button>

      <div class="mt-3">
        <div class="form-row">
          <div class="form-group col-md-3"><label>Subtotal</label><input readonly id="subtotal" class="form-control" name="subtotal"></div>
          <div class="form-group col-md-3"><label>Total Discount</label><input readonly id="total_discount" class="form-control" name="total_discount"></div>
          <div class="form-group col-md-3"><label>Total GST</label><input readonly id="total_gst" class="form-control" name="total_gst"></div>
          <div class="form-group col-md-3"><label>Grand Total</label><input readonly id="grand_total" class="form-control" name="grand_total"></div>
        </div>
      </div>

      <button class="btn btn-primary">Save Invoice</button>
    </form>
  </div>
</div>

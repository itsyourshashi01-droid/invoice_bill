<?php
// invoice_create.php
// Assumes a db.php file with $conn = new mysqli(...) or change to your connection method
include("db.php");

// Fetch customers & products
$customers = $conn->query("SELECT * FROM customers ORDER BY customer_name");
$products  = $conn->query("SELECT * FROM products ORDER BY product_name");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Create Invoice | MedicalAPP</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
body{font-family:'Segoe UI',Arial;background:#f4f6f8;padding:18px;}
.container-card{background:#fff;padding:20px;border-radius:12px;box-shadow:0 6px 18px rgba(20,20,20,0.08);}
.header-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;}
.btn-primary{background:#0078d4;border:none;}
.table thead th{background:#1f1f1f;color:#fff;}
.input-read{background:#f3f3f3;}
.qty{width:100px;}
.amount{width:150px;}
.select2-container .select2-selection--single{height:38px !important;padding:5px;border-radius:6px;border:1px solid #ccc;}
.select2-container--default .select2-selection--single .select2-selection__arrow{height:38px !important;}
</style>
</head>

<body>

<div class="container">
  <div class="container-card">

    <div class="header-row">
      <h3>Create Invoice</h3>
      <div>
        <a href="invoice_list.php" class="btn btn-outline-secondary">Back</a>
        <!-- reference sample PDF (local path you uploaded) -->
        <a href="/mnt/data/Invoice - SM250032.pdf" target="_blank" class="btn btn-sm btn-secondary">Sample PDF</a>
      </div>
    </div>

    <form id="invoiceForm" action="save_invoice.php" method="POST">

      <!-- CUSTOMER SECTION -->
      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Customer</label>
          <div class="d-flex">
            <select id="customerSelect" name="customer_id" class="form-control" required>
              <option value="">-- Select Customer --</option>
              <?php while($c = $customers->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"
                  data-name="<?= htmlspecialchars($c['customer_name']); ?>"
                  data-doctor="<?= htmlspecialchars($c['doctor_name']); ?>"
                  data-address="<?= htmlspecialchars($c['address']); ?>"
                  data-gstin="<?= htmlspecialchars($c['gstin']); ?>"
                >
                  <?= htmlspecialchars($c['customer_name']); ?>
                </option>
              <?php endwhile; ?>
            </select>
            <button type="button" class="btn btn-outline-primary ml-2" data-toggle="modal" data-target="#modalAddCustomer">+ Customer</button>
          </div>
        </div>

        <div class="form-group col-md-3">
          <label>Bill No</label>
          <input type="text" name="bill_no" class="form-control" value="<?='SM'.rand(100000,999999)?>" required>
        </div>

        <div class="form-group col-md-2">
          <label>Date</label>
          <input type="date" name="date_time" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group col-md-3 text-right">
          <label>&nbsp;</label><br>
          <button type="button" class="btn btn-outline-primary" id="btnAddRow">+ Add Item</button>
          <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modalAddProduct">+ Product</button>
        </div>
      </div>

      <!-- AUTO-FILL CUSTOMER INFO -->
      <div class="form-row mb-3">
        <div class="form-group col-md-3">
          <label>Customer Name</label>
          <input id="customer_name" class="form-control input-read" readonly>
        </div>

        <div class="form-group col-md-3">
          <label>Doctor / Hospital</label>
          <input id="doctor_name" class="form-control input-read" readonly>
        </div>

        <div class="form-group col-md-4">
          <label>Address</label>
          <input id="address" class="form-control input-read" readonly>
        </div>

        <div class="form-group col-md-2">
          <label>GSTIN</label>
          <input id="gstin" class="form-control input-read" readonly>
        </div>
      </div>

      <!-- ITEMS TABLE -->
      <div class="table-responsive">
      <table class="table table-bordered" id="itemsTable">
        <thead>
          <tr>
            <th style="min-width:250px;">Product</th>
            <th>Batch</th>
            <th>Expiry</th>
            <th>HSN</th>
            <th>MFG</th>
            <th>Stock</th>
            <th>Qty</th>
            <th>MRP</th>
            <th>Disc%</th>
            <th>GST%</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
        <tr>
          <td>
            <select name="product_id[]" class="form-control product-select">
              <option value="">Select product</option>
              <?php
              $products->data_seek(0);
              while($p = $products->fetch_assoc()):
              ?>
                <option value="<?= $p['id'] ?>"
                  data-batch="<?= htmlspecialchars($p['batch']); ?>"
                  data-expiry="<?= htmlspecialchars($p['expiry']); ?>"
                  data-hsn="<?= htmlspecialchars($p['hsn']); ?>"
                  data-mfg="<?= htmlspecialchars($p['mfg']); ?>"
                  data-mrp="<?= $p['mrp']; ?>"
                  data-gst="<?= $p['gst_percent']; ?>"
                  data-qty="<?= $p['qty']; ?>"
                >
                  <?= htmlspecialchars($p['product_name'])." | Batch: ".$p['batch']." | HSN: ".$p['hsn']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </td>

          <td><input name="batch[]" class="form-control batch" readonly></td>
          <td><input name="expiry[]" class="form-control expiry" readonly></td>
          <td><input name="hsn[]" class="form-control hsn" readonly></td>
          <td><input name="mfg[]" class="form-control mfg" readonly></td>
          <td><input name="available_qty[]" class="form-control available_qty" readonly></td>

          <td><input type="number" name="qty[]" class="form-control qty" min="1"></td>
          <td><input type="number" name="mrp[]" class="form-control mrp" step="0.01"></td>
          <td><input type="number" name="discount[]" class="form-control discount" value="0"></td>
          <td><input type="number" name="gst[]" class="form-control gst"></td>
          <td><input type="number" name="amount[]" class="form-control amount" readonly></td>

          <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>
        </tbody>
      </table>
      </div>

      <!-- TOTAL SUMMARY -->
      <div class="row mt-3">
        <div class="col-md-7">
          <label>Notes (optional)</label>
          <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-md-5">
          <table class="table table-borderless">
            <tr><td>Subtotal</td><td><input id="subtotal" name="subtotal" class="form-control input-read" readonly></td></tr>
            <tr><td>Total Discount</td><td><input id="total_discount" name="total_discount" class="form-control input-read" readonly></td></tr>
            <tr><td>Total GST</td><td><input id="total_gst" name="total_gst" class="form-control input-read" readonly></td></tr>
            <tr><td><b>Grand Total</b></td><td><input id="grand_total" name="grand_total" class="form-control input-read" readonly></td></tr>
          </table>
        </div>
      </div>

      <div class="text-right">
        <button type="submit" class="btn btn-primary btn-lg">Save Invoice</button>
      </div>

    </form>
  </div>
</div>

<!-- ===== MODAL: Add Product ===== -->
<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="formAddProduct">
        <div class="modal-header">
          <h5 class="modal-title">Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <!-- fields -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Product Name</label>
              <input name="product_name" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Batch</label>
              <input name="batch" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
              <label>Expiry</label>
              <input type="date" name="expiry" class="form-control" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>MRP</label>
              <input name="mrp" type="number" step="0.01" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label>Purchase Rate</label>
              <input name="purchase_rate" type="number" step="0.01" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>GST %</label>
              <input name="gst_percent" type="number" step="0.01" class="form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>HSN</label>
              <input name="hsn" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Manufacturer</label>
              <input name="mfg" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Quantity</label>
              <input name="qty" type="number" class="form-control" value="0">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===== MODAL: Add Customer ===== -->
<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="formAddCustomer">
        <div class="modal-header">
          <h5 class="modal-title">Add New Customer</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Customer Name</label>
            <input name="customer_name" class="form-control" required>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Contact</label>
              <input name="contact" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label>GSTIN</label>
              <input name="gstin" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label>Doctor / Hospital (optional)</label>
            <input name="doctor_name" class="form-control">
          </div>

          <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS libs -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* small utility */
function toFloat(v){ return parseFloat(v)||0; }

/* SELECT2 activation */
function activateSelect2(){
  $('.product-select').select2({
    width:"100%",
    placeholder:"Search product..."
  });
  $('#customerSelect').select2({ width: "100%", placeholder: "Select customer" });
}
activateSelect2();

/* CUSTOMER AUTO-FILL */
$('#customerSelect').on('change', function(){
    var o = $(this).find(":selected");
    $('#customer_name').val(o.data('name')||'');
    $('#doctor_name').val(o.data('doctor')||'');
    $('#address').val(o.data('address')||'');
    $('#gstin').val(o.data('gstin')||'');
});

/* PRODUCT AUTO-FILL */
$(document).on('change', '.product-select', function(){
  var o = $(this).find(":selected");
  var r = $(this).closest('tr');
  r.find('.batch').val(o.data('batch')||'');
  r.find('.expiry').val(o.data('expiry')||'');
  r.find('.hsn').val(o.data('hsn')||'');
  r.find('.mfg').val(o.data('mfg')||'');
  r.find('.mrp').val(o.data('mrp')||'');
  r.find('.gst').val(o.data('gst')||'');
  r.find('.available_qty').val(o.data('qty')||'');
  recalcRow(r);
});

/* ADD ROW (handle select2 cleanup/cloning) */
$('#btnAddRow').on('click', function(){
  var first = $('#itemsTable tbody tr:first');
  var clone = first.clone();

  // clear input values
  clone.find('input').val('');
  clone.find('select').val('').trigger('change');

  // remove any select2 containers (from cloned DOM)
  clone.find('.select2').remove();
  clone.find('select').removeClass("select2-hidden-accessible");

  $('#itemsTable tbody').append(clone);
  activateSelect2();
});

/* REMOVE ROW */
$(document).on('click', '.remove-row', function(){
  if($('#itemsTable tbody tr').length>1){
      $(this).closest('tr').remove();
      recalcAll();
  } else {
      var r = $(this).closest('tr'); r.find('input,select').val(''); recalcAll();
  }
});

/* calculation handlers */
$(document).on('input', '.qty, .mrp, .discount, .gst', function(){ recalcRow($(this).closest('tr')); });

function recalcRow(r){
  var qty = toFloat(r.find('.qty').val());
  var mrp = toFloat(r.find('.mrp').val());
  var disc = toFloat(r.find('.discount').val());
  var gst = toFloat(r.find('.gst').val());
  var stock = toFloat(r.find('.available_qty').val());

  if(qty>stock && stock>0){ alert('Only '+stock+' available'); r.find('.qty').val(stock); qty=stock; }

  var base = qty*mrp;
  var discAmt = base*(disc/100);
  var afterDisc = base - discAmt;
  var gstAmt = afterDisc*(gst/100);
  var final = afterDisc + gstAmt;

  r.find('.amount').val(final.toFixed(2));
  recalcAll();
}

function recalcAll(){
  var subtotal=0, totalD=0, totalG=0, grand=0;
  $('#itemsTable tbody tr').each(function(){
    var qty = toFloat($(this).find('.qty').val());
    var mrp = toFloat($(this).find('.mrp').val());
    var disc = toFloat($(this).find('.discount').val());
    var gst = toFloat($(this).find('.gst').val());
    if(qty<=0) return;
    var base = qty*mrp;
    var d = base*(disc/100);
    var sub = base - d;
    var g = sub*(gst/100);
    var tot = sub + g;
    subtotal += base; totalD += d; totalG += g; grand += tot;
  });
  $('#subtotal').val(subtotal.toFixed(2));
  $('#total_discount').val(totalD.toFixed(2));
  $('#total_gst').val(totalG.toFixed(2));
  $('#grand_total').val(grand.toFixed(2));
}

/* ---------- AJAX: Add Product inline ---------- */
$('#formAddProduct').on('submit', function(e){
  e.preventDefault();
  var data = $(this).serialize();
  $.post('product_add_ajax.php', data, function(res){
    try {
      var json = JSON.parse(res);
    } catch(e){ alert('Server error: '+res); return; }
    if(json.success){
      // build option text and add to all product-selects
      var text = json.product.product_name + ' | Batch: ' + json.product.batch + ' | HSN: ' + json.product.hsn;
      var newOption = new Option(text, json.product.id, false, false);
      // add to each select and trigger select2 update
      $('.product-select').each(function(){
        $(this).append($(newOption).clone()).trigger('change');
      });
      $('#modalAddProduct').modal('hide');
      $('#formAddProduct')[0].reset();
      alert('Product added');
    } else {
      alert('Error: ' + (json.error || 'Unknown'));
    }
  });
});

/* ---------- AJAX: Add Customer inline ---------- */
$('#formAddCustomer').on('submit', function(e){
  e.preventDefault();
  var data = $(this).serialize();
  $.post('customer_add_ajax.php', data, function(res){
    try {
      var json = JSON.parse(res);
    } catch(e){ alert('Server error: '+res); return; }
    if(json.success){
      var c = json.customer;
      var text = c.customer_name;
      var opt = new Option(text, c.id, false, false);
      $('#customerSelect').append(opt).val(c.id).trigger('change'); // select newly added
      $('#modalAddCustomer').modal('hide');
      $('#formAddCustomer')[0].reset();
      alert('Customer added and selected');
    } else {
      alert('Error: ' + (json.error || 'Unknown'));
    }
  });
});

/* prevent empty invoice submit */
$('#invoiceForm').on('submit', function(e){
  var ok=false;
  $('#itemsTable tbody tr').each(function(){
    if($(this).find('.product-select').val() && toFloat($(this).find('.qty').val())>0) ok=true;
  });
  if(!ok){ alert('Please add at least one product with quantity'); e.preventDefault(); return false; }
});
</script>

</body>
</html>

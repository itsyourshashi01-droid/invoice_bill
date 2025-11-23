// assets/script.js
$(document).ready(function(){
  function recalc(){
    let subtotal = 0, total_discount = 0, total_gst = 0;
    $('#itemsTable tbody tr').each(function(){
      let qty = parseFloat($(this).find('.qty').val()) || 0;
      let mrp = parseFloat($(this).find('.mrp').val()) || 0;
      let disc = parseFloat($(this).find('.discount').val()) || 0;
      let gst = parseFloat($(this).find('.gst').val()) || 0;

      let amount = qty * mrp;
      let disc_amt = amount * (disc/100);
      let after_disc = amount - disc_amt;
      let gst_amt = after_disc * (gst/100);
      let row_total = after_disc + gst_amt;

      $(this).find('.amount-cell').text(row_total.toFixed(2));

      subtotal += amount;
      total_discount += disc_amt;
      total_gst += gst_amt;
    });

    $('#subtotal').val(subtotal.toFixed(2));
    $('#total_discount').val(total_discount.toFixed(2));
    $('#total_gst').val(total_gst.toFixed(2));
    $('#grand_total').val((subtotal - total_discount + total_gst).toFixed(2));
  }

  $('#itemsTable').on('input', '.qty, .mrp, .discount, .gst', recalc);

  $('#addRow').click(function(){
    let row = `<tr>
      <td><input name="product_name[]" class="form-control" required></td>
      <td><input name="qty[]" class="form-control qty" value="1" type="number" step="0.01" required></td>
      <td><input name="mrp[]" class="form-control mrp" type="number" step="0.01" required></td>
      <td><input name="discount[]" class="form-control discount" type="number" step="0.01" value="0"></td>
      <td><input name="gst[]" class="form-control gst" type="number" step="0.01" value="0"></td>
      <td class="amount-cell">0.00</td>
      <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
    </tr>`;
    $('#itemsTable tbody').append(row);
  });

  $('#itemsTable').on('click', '.removeRow', function(){
    $(this).closest('tr').remove();
    recalc();
  });

  // initial calc
  recalc();
});
// Activate DataTables on all tables
$(document).ready(function () {
    $('table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'print'
        ]
    });
});

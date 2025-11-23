function addRow() {
    let table = document.getElementById("itemTable");
    let row = table.insertRow();

    row.innerHTML = `
        <td><input type="text" name="product_name[]" required></td>
        <td><input type="number" name="qty[]" required></td>
        <td><input type="number" step="0.01" name="mrp[]" required></td>
        <td><input type="text" name="mfg[]"></td>
        <td><input type="text" name="hsn[]"></td>
        <td><input type="text" name="batch[]"></td>
        <td><input type="date" name="expiry[]"></td>
        <td><input type="number" step="0.01" name="discount[]"></td>
        <td><input type="number" step="0.01" name="gst[]"></td>
        <td><button type="button" onclick="removeRow(this)">X</button></td>
    `;
}

function removeRow(btn) {
    let row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

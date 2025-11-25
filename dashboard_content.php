<?php
// dashboard_content.php
// Safe dashboard content that can be loaded via layout or ajax_page.php

include("db.php");

/**
 * safeCount: return integer count for a table, or 0 if query fails.
 * Also logs an error message to $errors so the page can show what went wrong.
 */
$errors = [];

function safeCount($conn, $table, &$errors) {
    // basic table name validation (letters, numbers, underscore)
    if (!preg_match('/^[a-z0-9_]+$/i', $table)) {
        $errors[] = "Invalid table name: " . htmlspecialchars($table);
        return 0;
    }
    $sql = "SELECT COUNT(*) AS total FROM `$table`";
    $res = $conn->query($sql);
    if (!$res) {
        $errors[] = "Query failed for table `$table`: " . $conn->error;
        return 0;
    }
    $row = $res->fetch_assoc();
    return isset($row['total']) ? (int)$row['total'] : 0;
}

// Use actual table names that exist in your DB.
// If a table name differs in your DB, change the string below accordingly.
$total_products  = safeCount($conn, "smh_stock", $errors); // most likely your stock table
$total_customers = safeCount($conn, "customers", $errors);
$total_invoices  = safeCount($conn, "invoices", $errors);
$total_purchases = safeCount($conn, "purchases", $errors);
?>

<div class="page-header">
    <h2>Dashboard</h2>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-warning">
    <strong>Database warnings:</strong>
    <ul>
      <?php foreach($errors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
    <p class="small text-muted">If a table is missing, check your database schema or rename the table names above.</p>
  </div>
<?php endif; ?>

<div class="stats-grid d-flex flex-wrap" style="gap:16px;">
    <div class="card p-3" style="width:220px;">
        <div class="h1 mb-0"><?= $total_products ?></div>
        <div class="text-muted">Medicine Stock (SMH)</div>
    </div>

    <div class="card p-3" style="width:220px;">
        <div class="h1 mb-0"><?= $total_customers ?></div>
        <div class="text-muted">Total Customers</div>
    </div>

    <div class="card p-3" style="width:220px;">
        <div class="h1 mb-0"><?= $total_invoices ?></div>
        <div class="text-muted">Total Invoices</div>
    </div>

    <div class="card p-3" style="width:220px;">
        <div class="h1 mb-0"><?= $total_purchases ?></div>
        <div class="text-muted">Total Purchases</div>
    </div>
</div>

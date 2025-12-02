<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.html?error=Please login first");
    exit;
}

// Restrict access
if($_SESSION['admin'] !== 'stock_admin' && basename($_SERVER['PHP_SELF']) === 'stock.php') {
    die("Access denied: Stock Admins only");
}

include('dbconnect.php');

// =======================
// MONTH FILTER
// =======================
$filterMonth = isset($_POST['filter_month']) ? $_POST['filter_month'] : date('Y-m'); // default current month

// =======================
// FETCH SUMMARY DATA
// =======================
$summarySql = "SELECT item_name, total, approval_status 
               FROM summary_table 
               WHERE DATE_FORMAT(created_at, '%Y-%m') = '$filterMonth'";
$summaryResult = $conn->query($summarySql);

$summaryData = [];
$approvalStatus = 'Pending';
if ($summaryResult) {
    while ($row = $summaryResult->fetch_assoc()) {
        $summaryData[$row['item_name']] = $row['total'];
        $approvalStatus = $row['approval_status']; // Assuming all rows same status
    }
}

// =======================
// FETCH STOCK DATA
// =======================
$stockSql = "SELECT * FROM stock";
$result = $conn->query($stockSql);

// =======================
// UPDATE STOCK
// =======================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_stock'])) {
    foreach ($_POST['stock'] as $id => $value) {
        $id = intval($id);
        $newStock = intval($value);
        $conn->query("UPDATE stock SET current_stock='$newStock' WHERE id='$id'");
    }
    $messages[] = ['type'=>'success','text'=>'🛠️ Stock quantities updated successfully.'];
}

// =======================
// DELIVER STOCK
// =======================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deliver_stock'])) {

    if ($approvalStatus !== 'Approved') {
        $messages[] = ['type'=>'warning','text'=>'⚠️ Cannot deliver — items have not been approved yet.'];
    } else {
        $getItems = $conn->query("SELECT id, item_name, current_stock FROM stock");

        while ($row = $getItems->fetch_assoc()) {
            $itemName = $row['item_name'];
            $currentStock = (int)$row['current_stock'];
            $requested = isset($summaryData[$itemName]) ? (int)$summaryData[$itemName] : 0;

            $newStock = max(0, $currentStock - $requested);

            // Update summary_table as delivered
            $conn->query("UPDATE summary_table 
                          SET approval_status='Delivered', delivered_at=NOW() 
                          WHERE item_name='$itemName' 
                          AND DATE_FORMAT(created_at, '%Y-%m')='$filterMonth'");

            // Update stock
            $conn->query("UPDATE stock 
                          SET current_stock='$newStock' 
                          WHERE id='{$row['id']}'");
        }
        $messages[] = ['type'=>'success','text'=>'📦 Items successfully delivered. Stock updated.'];
    }
}

// =======================
// PREPARE TABLE ROWS
// =======================
$rows = [];
$result = $conn->query($stockSql);
while ($row = $result->fetch_assoc()) {
    $itemName = $row['item_name'];
    $requested = isset($summaryData[$itemName]) ? $summaryData[$itemName] : 0;
    $difference = $row['current_stock'] - $requested;

    $rows[] = [
        'id' => $row['id'],
        'itemName' => $itemName,
        'current_stock' => $row['current_stock'],
        'requestedStock' => $requested,
        'difference' => $difference
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Stock Management</title>
<style>
body { font-family: Arial,sans-serif; background:#f0f0f0; margin:0; padding:0;}
header { background: rgba(75,7,109,0.6); color:white; padding:15px; text-align:center; }
nav ul { list-style:none; padding:0; margin:0; display:flex; justify-content:center; background:rgba(89,46,131,0.85);}
nav ul li a { display:block; color:white; padding:8px 15px; text-decoration:none; font-weight:bold; border-radius:4px;}
nav ul li a:hover { background-color: rgba(75,0,130,0.9); }
h2 { text-align:center; margin:20px; color:#333;}
.container-box { width:85%; max-width:800px; margin:15px auto; background:#fff; padding:15px; border-radius:8px; box-shadow:0 3px 8px rgba(0,0,0,0.1);}
.alert { width:80%; max-width:750px; margin:10px auto; padding:12px; border-radius:5px; border-left:5px solid; font-size:14px;}
.alert-success { background:#d4edda; color:#155724; border-color:#28a745; }
.alert-warning { background:#fff3cd; color:#856404; border-color:#ffc107; }
.alert-delivered { background:#e2f0cb; color:#2d6a4f; border-color:#7cb518; }
.buttons { display:flex; justify-content:center; gap:10px; margin-bottom:15px; }
button { padding:7px 12px; font-size:13px; border:none; border-radius:5px; cursor:pointer; }
button[name="update_stock"] { background:#3e2559; color:white; }
button[name="deliver_stock"] { background:#28a745; color:white; }
button:disabled { opacity:0.6; cursor:not-allowed; }
table { width:100%; border-collapse:collapse; background:white; border-radius:6px; overflow:hidden;}
th, td { padding:6px 8px; text-align:center; border:1px solid #ddd; font-size:12px;}
th { background-color:#5a2e83; color:white;}
tr:nth-child(even){background:#f9f9f9;}
input[type='number'] { width:45px; padding:3px; font-size:12px; border:1px solid #ccc; border-radius:4px; text-align:center; }
input[type='number']:focus { border-color:#5a2e83; outline:none;}
</style>
</head>
<body>

<header>
    <h1>Stock Management</h1>
    <nav>
<ul>
<li><a href="home.html">Home</a></li>
<li><a href="form.html">Request Stationery</a></li>
<li><a href="adminlogin.html">Stock Management</a></li>
<li><a href="login.html">Admin Dashboard</a></li>
<li><a href="report.php">Report</a></li>
<li><a href="adminlgout.php">Logout</a></li>
</ul>
</nav>
</header>

<h2>Update & Deliver Stock</h2>

<form method="post">
<div style="text-align:center; margin-bottom:10px;">
    <label>Filter Month: 
        <input type="month" name="filter_month" value="<?= htmlspecialchars($filterMonth) ?>">
    </label>
    <button type="submit">Apply</button>
</div>

<div class="buttons">
    <button type="submit" name="update_stock">🛠️ Update Stock</button>
    <button type="submit" name="deliver_stock" <?php if($approvalStatus!=='Approved') echo "disabled"; ?>>🚚 Deliver Stock</button>
</div>

<?php
if (!empty($messages)) {
    foreach($messages as $m) {
        $cls = $m['type']==='success'?'alert-success':($m['type']==='warning'?'alert-warning':'alert-delivered');
        echo "<div class='alert $cls'>".$m['text']."</div>";
    }
}
?>

<div class="container-box">
<table>
    <tr>
        <th>Item Name</th>
        <th>Current Stock</th>
        <th>Requested</th>
        <th>Difference</th>
    </tr>
    <?php foreach($rows as $r): ?>
    <tr>
        <td><?= htmlspecialchars($r['itemName']) ?></td>
        <td><input type="number" name="stock[<?= $r['id'] ?>]" value="<?= $r['current_stock'] ?>"></td>
        <td><?= $r['requestedStock'] ?></td>
        <td style="<?= $r['difference']<=0?'color:red;font-weight:bold':'' ?>"><?= $r['difference'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</form>

</body>
</html>

<?php $conn->close(); ?>



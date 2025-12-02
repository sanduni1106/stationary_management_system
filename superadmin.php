<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php?error=Please login first");
    exit;
}

// Restrict specific pages
if($_SESSION['admin'] !== 'summary_admin' && basename($_SERVER['PHP_SELF']) === 'summary.php') {
    die("Access denied: Summary Admins only");
}

// Include DB
include('dbconnect.php');

// =====================
// Handle Approve / Cancel
// =====================
$items = [
    'bluePen', 'blackPen', 'redPen', 'a4paper', 'a4orange', 'file1', 'file2', 
    'fileTags', 'cover6x3', 'cover9x4', 'cover10x7', 'cover10x15', 'stickyPack', 
    'stickyPackSheets', 'crPaper40', 'crPaper80', 'crPaper120', 'crPaper160', 
    'tippex', 'cellotape', 'pinsPack', 'fileClip', 'stapler', 'manilaPapers', 
    'carbonPaper', 'halfSheet', 'highlighter', 'pencils', 'eraser', 'notebook', 
    'rulePaper', 'legalPaper', 'glueBottles', 'inkBottle'
];

$branchTotals = [
    'establishment_section' => [], 'account_section' => [], 'sports_section' => [], 
    'development_section' => [], 'ruraldev_section' => [], 'cultural_section' => []
];

// Fetch current stock
$stockData = [];
$stockSql = "SELECT item_name, current_stock FROM stock";
$stockResult = $conn->query($stockSql);
if ($stockResult) {
    while ($row = $stockResult->fetch_assoc()) {
        $stockData[$row['item_name']] = $row['current_stock'];
    }
}

// Initialize totals
$allTotals = array_fill_keys($items, 0);

// Get approval map for table
$approvalMap = [];
$summaryResult = $conn->query("SELECT item_name, approval_status FROM summary_table");
if($summaryResult){
    while($row = $summaryResult->fetch_assoc()){
        $approvalMap[$row['item_name']] = $row['approval_status'];
    }
}

// Check low stock items
$lowStockItems = [];
$canApprove = true;
foreach ($items as $item) {
    $currentStock = isset($stockData[$item]) ? $stockData[$item] : 0;
    if ($currentStock <= 0) {
        $lowStockItems[] = ucfirst(str_replace('_',' ',$item));
        $canApprove = false;
    }
}

// =====================
// Approve
// =====================
if(isset($_POST['approve'])){
    if($canApprove){
        $conn->query("UPDATE summary_table SET approval_status='Approved'");
        $_SESSION['messages'] = [['type'=>'success','text'=>'✅ All items approved successfully!']];
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['messages'] = [['type'=>'warning','text'=>'⚠️ Cannot approve items. Some items are out of stock!']];
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}

// =====================
// Cancel
// =====================
if(isset($_POST['cancel'])){
    $conn->query("UPDATE summary_table SET approval_status='Pending'");
    $_SESSION['messages'] = [['type'=>'danger','text'=>'❌ Approval has been cancelled. All items reset to Pending!']];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// =====================
// Messages
// =====================
$messages = [];
if(isset($_SESSION['messages'])){
    $messages = $_SESSION['messages'];
    unset($_SESSION['messages']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stationery Management System</title>
<style>
body { font-family: Arial,sans-serif; margin:0; padding:0; background:#fff; color:#000; }
header { background: rgba(79,8,114,0.37); color:white; padding:10px; text-align:center; }
header h1 { margin:0; font-size:20px; }
header small { display:block; font-size:14px; margin-top:5px; }
nav ul { list-style:none; padding:0; margin:10px 0 0; display:flex; justify-content:center; background: rgba(102,51,153,0.77); }
nav ul li { margin:0; }
nav ul li a { display:block; color:white; padding:10px 15px; text-decoration:none; font-weight:bold; transition:0.3s; }
nav ul li a:hover { background: rgba(75,0,130,0.9); transform:scale(1.05); }
.container { width:95%; max-width:1200px; margin:20px auto; }
.alert { padding:10px; margin-bottom:10px; border-radius:4px; }
.alert.success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
.alert.warning { background:#fff3cd; color:#856404; border:1px solid #ffeeba; }
.alert.danger { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
.warning-list { padding:10px; border:1px solid red; background:#ffdddd; margin-bottom:10px; border-radius:4px; }
button.btn { padding:6px 12px; border:none; border-radius:5px; cursor:pointer; transition:0.2s; }
button.btn.success { background:#28a745; color:white; }
button.btn.success:disabled { background:#95d5b2; cursor:not-allowed; }
button.btn.danger { background:#dc3545; color:white; }
table { width:100%; border-collapse:collapse; box-shadow:0 4px 8px rgba(0,0,0,0.1); margin-top:10px; }
th,td { border:1px solid #ddd; padding:8px; text-align:center; font-size:13px; }
th { background: rgba(79,8,114,0.75); color:white; font-weight:bold; }
td { background:#f9f9f9; }
td.text-danger { color:red; font-weight:bold; }
tr:nth-child(even){ background:#f2f2f2; }
@media(max-width:768px){ th,td{ font-size:11px; padding:6px; } }
</style>
</head>
<body>
<header>
<h1>දකුණු පළාත් ක්‍රීඩා, යෞවන කටයුතු, ග්‍රාම සංවර්ධන අමාත්‍යංශය<br>Ministry of Sports — Dakshinapaya</h1>
<small>📦 Stationery Management System — Summary</small>
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

<div class="container">
<?php foreach($messages as $m): ?>
<div class="alert <?= $m['type']==='success'?'success':($m['type']==='warning'?'warning':'danger')?>"><?= htmlspecialchars($m['text']) ?></div>
<?php endforeach; ?>

<?php if(!empty($lowStockItems)): ?>
<div class="warning-list">
<strong>⚠️ Out of stock items:</strong> <?= implode(', ',$lowStockItems) ?>
</div>
<?php endif; ?>

<form method="post" id="approvalForm">
<button type="submit" name="approve" class="btn success" <?= $canApprove?'':'disabled' ?>>✅ Approve All</button>
<button type="submit" name="cancel" class="btn danger" style="margin-left:8px;">❌ Cancel Approval</button>
</form>

<table>
<thead>
<tr>
<th>Item</th><th>Establishment</th><th>Account</th><th>Sports</th>
<th>Development</th><th>Rural Dev</th><th>Cultural</th><th>All</th>
<th>Current Stock</th><th>Remaining</th><th>Approval Status</th>
</tr>
</thead>
<tbody>
<?php
// Fetch latest summary for table
$summaryRows = [];
$res = $conn->query("SELECT * FROM summary_table");
if($res){
    while($row=$res->fetch_assoc()){
        $summaryRows[$row['item_name']] = $row;
    }
}

foreach($items as $it):
$row = isset($summaryRows[$it])?$summaryRows[$it]:null;
$est = $row ? (int)$row['establishment_section']:0;
$acc = $row ? (int)$row['account_section']:0;
$spo = $row ? (int)$row['sports_section']:0;
$dev = $row ? (int)$row['development_section']:0;
$rur = $row ? (int)$row['ruraldev_section']:0;
$cul = $row ? (int)$row['cultural_section']:0;
$all = $row ? (int)$row['total']:0;
$cs = isset($stockData[$it]) ? (int)$stockData[$it] : 0;
$rem = $cs - $all;
$status = $row ? $row['approval_status']:'Pending';
$csStyle = $cs<=0?'text-danger':'';
$remStyle = $rem<0?'text-danger':'';
?>
<tr>
<td><?= ucfirst(str_replace('_',' ',$it)) ?></td>
<td><?= $est ?></td>
<td><?= $acc ?></td>
<td><?= $spo ?></td>
<td><?= $dev ?></td>
<td><?= $rur ?></td>
<td><?= $cul ?></td>
<td><strong><?= $all ?></strong></td>
<td class="<?= $csStyle ?>"><?= $cs ?></td>
<td class="<?= $remStyle ?>"><?= $rem ?></td>
<td><?= htmlspecialchars($status) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<script>
// Confirm Approve/Cancel
document.getElementById('approvalForm')?.addEventListener('submit',function(e){
const btn=document.activeElement;
if(btn && btn.name==='approve'){
if(!confirm('Approve all items?')) e.preventDefault();
} else if(btn && btn.name==='cancel'){
if(!confirm('Cancel approval?')) e.preventDefault();
}
});
</script>

<?php $conn->close(); ?>
</body>
</html>

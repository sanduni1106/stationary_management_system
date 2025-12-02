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
if($_SESSION['admin'] !== 'stock_admin' && basename($_SERVER['PHP_SELF']) === 'stock.php') {
    die("Access denied: Stock Admins only");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stationery Management System</title>
   
    <style>
    /* General Styles */
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: rgb(255, 255, 255);
    color: rgb(0, 0, 0); 
    justify-content:center;
    align-items: center;
    
}

/* Header */
header {
    background-color: rgba(79, 8, 114, 0.37); /* Fixed transparency */
    color: white;
    padding: 10px;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 20px;
}

/* Navigation */
nav ul {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    display: flex;
    justify-content: center;
    background: rgba(102, 51, 153, 0.77);
}

nav ul li {
    margin: 0;
    padding: 0;
}

nav ul li a {
    display: block;
    color: white;
    padding: 12px 18px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s; /* Smooth hover effect */
}

nav ul li a:hover {
    background-color: rgba(75, 0, 130, 0.9);
    transform: scale(1.05);
}
h2 {
    
    font-size: 28px;
    font-weight: 600;
    text-align: center;
}


/* General Styles for Table */
table {
    width: 80%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    align:center;
}

th, td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: rgba(79, 8, 114, 0.75); /* Header background */
    color: white;
    font-size: 14px;
    font-weight: bold;
}

td {
    background-color: #f9f9f9;
    font-size: 13px;
    color: #333;
    transition: background-color 0.3s;
}

td:hover {
    background-color: rgba(0, 0, 255, 0.1); /* Hover effect for cells */
}

/* Zebra Striping */
tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Responsive Table */
@media (max-width: 768px) {
    table {
        width: 100%;
        font-size: 12px;
    }

    th, td {
        padding: 8px;
    }
}

</style>
</head>
<body>
<header>
        <h1> දකුණු පළාත් ක්‍රීඩා, යෞවන කටයුතු, ග්‍රාම සංවර්ධන අමාත්‍යංශය<br>
       Ministry of Sports, Southern Province Dakshinapaya. </h1><br>
        <h1>📦 Stationery Management System</h1>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="form.html">Request Stationery</a></li>
                <li><a href="adminlogin.php">Approval Panel</a></li>
                <li><a href="login.html">Admin Dashboard</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="adminlgout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

<h3>📦 Stock Summary</h3>
<?php
include('dbconnect.php');



// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Initialize branch totals
$branchTotals = [
    'establishment_section' => [],
    'account_section' => [],
    'sports_section' => [],
    'development_section' => [],
    'ruraldev_section' => [],
    'cultural_section' => [],
];

// List of items
$items = [
    'bluePen', 'blackPen', 'redPen', 'a4paper', 'a4orange', 'file1', 'file2', 
    'fileTags', 'cover6x3', 'cover9x4', 'cover10x7', 'cover10x15', 'stickyPack', 
    'stickyPackSheets', 'crPaper40', 'crPaper80', 'crPaper120', 'crPaper160', 
    'tippex', 'cellotape', 'pinsPack', 'fileClip', 'stapler', 'manilaPapers', 
    'carbonPaper', 'halfSheet', 'highlighter', 'pencils', 'eraser', 'notebook', 
    'rulePaper', 'legalPaper', 'glueBottles', 'inkBottle'
];

// Initialize totals across all branches
$allTotals = array_fill_keys($items, 0);

// Fetch current stock from stock table
$stockData = [];
$stockSql = "SELECT item_name, current_stock FROM stock";
$stockResult = $conn->query($stockSql);
if ($stockResult) {
    while ($row = $stockResult->fetch_assoc()) {
        $stockData[$row['item_name']] = $row['current_stock'];
    }
}

// Loop through each branch to calculate totals
foreach ($branchTotals as $branch => &$totals) {
    $checkTableSql = "SHOW TABLES LIKE '$branch'";
    $tableResult = $conn->query($checkTableSql);

    if ($tableResult && $tableResult->num_rows > 0) {
        $sql = "SELECT 
                    SUM(COALESCE(bluePen,0)) AS bluePen,
                    SUM(COALESCE(blackPen,0)) AS blackPen,
                    SUM(COALESCE(redPen,0)) AS redPen,
                    SUM(COALESCE(a4paper,0)) AS a4paper,
                    SUM(COALESCE(a4orange,0)) AS a4orange,
                    SUM(COALESCE(file1,0)) AS file1,
                    SUM(COALESCE(file2,0)) AS file2,
                    SUM(COALESCE(fileTags,0)) AS fileTags,
                    SUM(COALESCE(cover6x3,0)) AS cover6x3,
                    SUM(COALESCE(cover9x4,0)) AS cover9x4,
                    SUM(COALESCE(cover10x7,0)) AS cover10x7,
                    SUM(COALESCE(cover10x15,0)) AS cover10x15,
                    SUM(COALESCE(stickyPack,0)) AS stickyPack,
                    SUM(COALESCE(stickyPackSheets,0)) AS stickyPackSheets,
                    SUM(COALESCE(crPaper40,0)) AS crPaper40,
                    SUM(COALESCE(crPaper80,0)) AS crPaper80,
                    SUM(COALESCE(crPaper120,0)) AS crPaper120,
                    SUM(COALESCE(crPaper160,0)) AS crPaper160,
                    SUM(COALESCE(tippex,0)) AS tippex,
                    SUM(COALESCE(cellotape,0)) AS cellotape,
                    SUM(COALESCE(pinsPack,0)) AS pinsPack,
                    SUM(COALESCE(fileClip,0)) AS fileClip,
                    SUM(COALESCE(stapler,0)) AS stapler,
                    SUM(COALESCE(manilaPapers,0)) AS manilaPapers,
                    SUM(COALESCE(carbonPaper,0)) AS carbonPaper,
                    SUM(COALESCE(halfSheet,0)) AS halfSheet,
                    SUM(COALESCE(highlighter,0)) AS highlighter,
                    SUM(COALESCE(pencils,0)) AS pencils,
                    SUM(COALESCE(eraser,0)) AS eraser,
                    SUM(COALESCE(notebook,0)) AS notebook,
                    SUM(COALESCE(rulePaper,0)) AS rulePaper,
                    SUM(COALESCE(legalPaper,0)) AS legalPaper,
                    SUM(COALESCE(glueBottles,0)) AS glueBottles,
                    SUM(COALESCE(inkBottle,0)) AS inkBottle
                FROM `$branch`
                WHERE MONTH(date)='$currentMonth' AND YEAR(date)='$currentYear'";

        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            foreach ($items as $item) {
                $totals[$item] = $row[$item];
                $allTotals[$item] += $row[$item];
            }
        }
    } else {
        foreach ($items as $item) {
            $totals[$item] = 0;
        }
    }
}

// Insert or update summary_table
foreach ($items as $item) {
    $est = $branchTotals['establishment_section'][$item];
    $acc = $branchTotals['account_section'][$item];
    $sports = $branchTotals['sports_section'][$item];
    $dev = $branchTotals['development_section'][$item];
    $rural = $branchTotals['ruraldev_section'][$item];
    $cult = $branchTotals['cultural_section'][$item];
    $total = $allTotals[$item];
    $currentStock = isset($stockData[$item]) ? $stockData[$item] : 0;
    $remaining = $currentStock - $total;

    $checkSql = "SELECT id FROM summary_table WHERE item_name='$item'";
    $res = $conn->query($checkSql);

    if ($res->num_rows > 0) {
        $updateSql = "UPDATE summary_table SET 
            establishment_section='$est',
            account_section='$acc',
            sports_section='$sports',
            development_section='$dev',
            ruraldev_section='$rural',
            cultural_section='$cult',
            total='$total',
            current_stock='$currentStock',
            remaining_stock='$remaining',
            updated_at=NOW()
            WHERE item_name='$item'";
        $conn->query($updateSql);
    } else {
        $insertSql = "INSERT INTO summary_table 
            (item_name, establishment_section, account_section, sports_section, development_section, ruraldev_section, cultural_section, total, current_stock, remaining_stock) 
            VALUES ('$item','$est','$acc','$sports','$dev','$rural','$cult','$total','$currentStock','$remaining')";
        $conn->query($insertSql);
    }
}

// Check low stock items and if approval is allowed
$lowStockItems = [];
$canApprove = true;
foreach ($items as $item) {
    $currentStock = isset($stockData[$item]) ? $stockData[$item] : 0;
    if ($currentStock <= 0) {
        $lowStockItems[] = ucfirst(str_replace('_',' ',$item));
        $canApprove = false;
    }
}


// Handle Approve button click
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['approve'])) {
    if ($canApprove) {
        $conn->query("UPDATE summary_table SET approval_status='Approved'");
        echo "<div style='background:#d4edda;color:#155724;padding:10px;margin-bottom:15px;border:1px solid #c3e6cb;'>✅ All items approved successfully!</div>";
    } else {
        echo "<div style='background:#fff3cd;color:#856404;padding:10px;margin-bottom:15px;border:1px solid #ffeeba;'>⚠️ Cannot approve items because some items have 0 stock!</div>";
    }
}

// Handle Cancel button click
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['cancel'])) {
    $conn->query("UPDATE summary_table SET approval_status='Pending'");
    echo "<div style='background:#f8d7da;color:#721c24;padding:10px;margin-bottom:15px;border:1px solid #f5c6cb;'>❌ Approval has been cancelled. All items reset to Pending!</div>";
}


?>

<!-- Notification -->
<?php if(!empty($lowStockItems)): ?>
<div style="background:#ffdddd;border:1px solid red;padding:6px;margin-bottom:10px;color:red;font-weight:bold;">
⚠️ Warning: The following items are out of stock: <?= implode(', ', $lowStockItems) ?>
</div>
<?php endif; ?>

<!-- Summary Table -->
<form method="post">
<table border="1" style="border-collapse:collapse;width:100%;">
<thead>
<tr style="background:#f2f2f2;">
    <th>Item</th>
    <th>Establishment</th>
    <th>Account</th>
    <th>Sports</th>
    <th>Development</th>
    <th>Rural Dev</th>
    <th>Cultural</th>
    <th>All</th>
    <th>Current Stock</th>
    <th>Remaining</th>
    <th>Approval Status</th>
</tr>
</thead>
<tbody>
<?php foreach($items as $item):
    $currentStock = isset($stockData[$item]) ? $stockData[$item] : 0;
    $remaining = $currentStock - $allTotals[$item];

    $stockStyle = ($currentStock <= 0) ? "color:red;font-weight:bold;" : "";
    $remainingStyle = ($remaining < 0) ? "color:red;font-weight:bold;" : "";

    $statusRes = $conn->query("SELECT approval_status FROM summary_table WHERE item_name='$item'");
    $approvalStatus = ($statusRes && $row=$statusRes->fetch_assoc()) ? $row['approval_status'] : 'Pending';
?>
<tr>
    <td><?= ucfirst(str_replace('_',' ',$item)) ?></td>
    <td><?= $branchTotals['establishment_section'][$item] ?></td>
    <td><?= $branchTotals['account_section'][$item] ?></td>
    <td><?= $branchTotals['sports_section'][$item] ?></td>
    <td><?= $branchTotals['development_section'][$item] ?></td>
    <td><?= $branchTotals['ruraldev_section'][$item] ?></td>
    <td><?= $branchTotals['cultural_section'][$item] ?></td>
    <td><?= $allTotals[$item] ?></td>
    <td style="<?= $stockStyle ?>"><?= $currentStock ?></td>
    <td style="<?= $remainingStyle ?>"><?= $remaining ?></td>
    <td><?= $approvalStatus ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div style="margin-top:20px;">
    <button type="submit" name="approve" 
        style="background:#28a745;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;"
        <?= $canApprove ? "" : "disabled" ?>>
        ✅ Approve All
    </button>

    <button type="submit" name="cancel" 
        style="background:#dc3545;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;margin-left:10px;">
        ❌ Cancel Approval
    </button>
</div>

</form>

<?php $conn->close(); ?>

</body>


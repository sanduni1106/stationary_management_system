<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.html?error=Please login first");
    exit;
}

include('dbconnect.php');

// Default to current month/year
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear  = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Build date range for the selected month
$startDate = date("Y-m-01", strtotime("$selectedYear-$selectedMonth-01"));
$endDate   = date("Y-m-t", strtotime($startDate)); // last day of month

// Fetch data from summary_table
$sql = "SELECT item_name, establishment_section, account_section, sports_section, development_section, ruraldev_section, cultural_section, total, approval_status, updated_at 
        FROM summary_table 
        WHERE updated_at BETWEEN '$startDate' AND '$endDate'";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>📊 Monthly Report</title>
<style>
    body { font-family: Arial, sans-serif; padding: 20px; background:#f9f9f9; }
    h1 { text-align: center; }
    form { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background:white; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #2c3e50; color:white; }
    .approved { color: green; font-weight: bold; }
    .pending { color: orange; font-weight: bold; }
    .rejected { color: red; font-weight: bold; }
    .btn-container { text-align:right; margin:15px 0; }
    button { padding:8px 15px; border:none; background:#2c3e50; color:white; cursor:pointer; border-radius:5px; }
    button:hover { background:#34495e; }
</style>
</head>
<body>

<?php
include('dbconnect.php');

// Set timezone
date_default_timezone_set('Asia/Colombo');

// Auto-select current month & year
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear  = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Date range for query
$startDate = "$selectedYear-$selectedMonth-01";
$endDate   = date("Y-m-t", strtotime($startDate));

// Fetch summary data
$sql = "
    SELECT 
        item_name,
        establishment_section,
        account_section,
        sports_section,
        development_section,
        ruraldev_section,
        cultural_section,
        total,
        approval_status,
        updated_at
    FROM summary_table
    WHERE DATE(updated_at) BETWEEN '$startDate' AND '$endDate'
    ORDER BY item_name ASC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monthly Stationery Report</title>
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f8f9fa;
        color: #333;
    }

    h1 {
        text-align: center;
        background: #4b0770;
        color: white;
        padding: 20px 0;
        margin: 0;
        font-size: 26px;
        letter-spacing: 1px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    form {
        text-align: center;
        margin: 20px auto;
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        width: 90%;
        max-width: 700px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    label {
        margin: 0 10px;
        font-weight: bold;
    }

    select {
        padding: 6px 10px;
        border-radius: 4px;
        border: 1px solid #aaa;
        font-size: 14px;
    }

    button {
        padding: 8px 14px;
        background: #5a2e83;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }

    button:hover {
        background: #3e1f63;
    }

    .btn-container {
        text-align: right;
        width: 90%;
        max-width: 1000px;
        margin: 0 auto 15px;
    }

    .btn-container button {
        background: #343a40;
    }

    .btn-container button:hover {
        background: #23272b;
    }

    table {
        width: 90%;
        max-width: 1000px;
        margin: 10px auto 30px;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 8px 10px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 13px;
    }

    th {
        background: #5a2e83;
        color: white;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    /* Status colors */
    .approved { color: green; font-weight: bold; }
    .pending { color: orange; font-weight: bold; }
    .delivered { color: blue; font-weight: bold; }
    .rejected { color: red; font-weight: bold; }

    /* Print Styles */
    @media print {
        form, .btn-container, h1 {
            display: none;
        }
        table {
            box-shadow: none;
            width: 100%;
            font-size: 12px;
        }
        body {
            background: white;
        }
    }
</style>
</head>

<body>

<h1>📊 Monthly Stationery Report</h1>

<!-- Filter Form -->
<form method="get">
    <label>Select Month:
        <select name="month">
            <?php for($m=1; $m<=12; $m++): 
                $val = str_pad($m,2,'0',STR_PAD_LEFT); ?>
                <option value="<?= $val ?>" <?= ($val==$selectedMonth)?'selected':'' ?>>
                    <?= date("F", mktime(0,0,0,$m,1)) ?>
                </option>
            <?php endfor; ?>
        </select>
    </label>

    <label>Select Year:
        <select name="year">
            <?php for($y=date('Y'); $y>=2020; $y--): ?>
                <option value="<?= $y ?>" <?= ($y==$selectedYear)?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
    </label>

    <button type="submit">Generate Report</button>
</form>

<div class="btn-container">
    <button onclick="window.print()">🖨 Print Report</button>
</div>

<!-- Report Table -->
<?php if($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Establishment</th>
            <th>Account</th>
            <th>Sports</th>
            <th>Development</th>
            <th>Rural Dev</th>
            <th>Cultural</th>
            <th>Total Delivered</th>
            <th>Approval Status</th>
            <th>Last Updated</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= ucfirst($row['item_name']) ?></td>
            <td><?= $row['establishment_section'] ?></td>
            <td><?= $row['account_section'] ?></td>
            <td><?= $row['sports_section'] ?></td>
            <td><?= $row['development_section'] ?></td>
            <td><?= $row['ruraldev_section'] ?></td>
            <td><?= $row['cultural_section'] ?></td>
            <td><b><?= $row['total'] ?></b></td>
            <td class="<?= strtolower($row['approval_status']) ?>"><?= $row['approval_status'] ?></td>
            <td><?= $row['updated_at'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p style="text-align:center; color:red;">No records found for <?= date("F Y", strtotime($startDate)) ?>.</p>
<?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>

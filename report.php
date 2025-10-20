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

</body>
</html>

<?php $conn->close(); ?>

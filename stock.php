<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.html?error=Please login first");
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


<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "stationary_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update stock if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['stock'] as $id => $newStock) {
        $newStock = intval($newStock);
        $conn->query("UPDATE stock SET current_stock = $newStock WHERE id = $id");
    }
}

// Fetch stock data
$result = $conn->query("SELECT * FROM stock");

// Fetch summary table data
$summaryResult = $conn->query("SELECT item_name, total FROM summary_table");
$summaryData = [];
while ($row = $summaryResult->fetch_assoc()) {
    $summaryData[$row['item_name']] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgba(238, 238, 238, 0.99);
            color: #fff;
        }

        header {
            background-color: rgba(75, 7, 109, 0.37);
            color: white;
            padding: 25px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 26px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0;
            display: flex;
            justify-content: center;
            background: rgba(89, 46, 131, 0.77);
        }

        nav ul li {
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        nav ul li a:hover {
            background-color: rgba(75, 0, 130, 0.9);
            transform: scale(1.05);
        }

        h2 {
            margin: 0;
            font-size: 26px;
            color:#333;
        }

        table {
            width: 70%;
            margin: 16px auto;
            border-collapse: collapse;
            background: white;
            color: black;
            border: 1px solid #ccc;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 4px 6px;
            text-align: center;
            border: 1px solid #ddd;
        }

        input[type='number'] {
            width: 60px;
            padding: 3px;
            font-size: 13px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        th:nth-child(1), td:nth-child(1) { width: 20%; }
        th:nth-child(2), td:nth-child(2) { width: 15%; }
        th:nth-child(3), td:nth-child(3) { width: 15%; }
        th:nth-child(4), td:nth-child(4) { width: 15%; }

        button {
            display: block;
            background-color: rgba(75, 0, 130, 0.9);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px auto;
            transition: 0.3s;
        }

        button:hover {
            background-color: rgba(89, 46, 131, 0.77);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<header>
    <h1>📦 Stock Management</h1>
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

<form method="post">
    <button type="submit">Update Stock</button>

    <?php 
    // Check approval
$statusResult = $conn->query("SELECT approval_status FROM summary_table LIMIT 1");
$approvalStatus = ($statusResult && $row=$statusResult->fetch_assoc()) ? $row['approval_status'] : 'Pending';

if ($approvalStatus === 'Approved') {
    echo "<div style='background:#d4edda;color:#155724;padding:10px;margin-bottom:15px;border:1px solid #c3e6cb;'>
        ✅ Items Approved. You can now deliver the stock.
    </div>";
} else {
    echo "<div style='background:#fff3cd;color:#856404;padding:10px;margin-bottom:15px;border:1px solid #ffeeba;'>
        ⏳ Waiting for admin approval before delivery.
    </div>";
}

    $alertItems = []; // Track items with low or zero stock

    // Collect rows for later printing
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $itemName = $row['item_name'];
        $requestedStock = isset($summaryData[$itemName]) ? $summaryData[$itemName] : 0;
        $difference = $row['current_stock'] - $requestedStock;

        // If difference is zero or negative, track it
        if ($difference <= 0) {
            $alertItems[] = $itemName;
        }

        $rows[] = [
            'id' => $row['id'],
            'itemName' => $itemName,
            'current_stock' => $row['current_stock'],
            'requestedStock' => $requestedStock,
            'difference' => $difference
        ];
    }
    ?>

    <!-- Notification Section -->
    <?php if (!empty($alertItems)): ?>
        <div style="background: #ffe0e0; color: #b30000; padding: 10px; margin: 10px 0; border: 1px solid #b30000; border-radius: 5px;">
            ⚠️ <strong>Warning:</strong> The following items have low or insufficient stock:<br>
            <?= htmlspecialchars(implode(", ", $alertItems)) ?>.
        </div>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Item Name</th>
            <th>Current Stock</th>
            <th>Requested Stock</th>
            <th>Difference (Current - Requested)</th>
        </tr>

        <?php foreach ($rows as $row): 
            $diffColor = ($row['difference'] <= 0) ? 'style="color: red; font-weight: bold;"' : '';
            $stockColor = ($row['current_stock'] <= 0) ? 'style="color: red; font-weight: bold;"' : '';
        ?>
        <tr>
            <td><?= htmlspecialchars($row['itemName']) ?></td>
            <td><input type="number" name="stock[<?= $row['id'] ?>]" value="<?= $row['current_stock'] ?>" <?= $stockColor ?>></td>
            <td><?= $row['requestedStock'] ?></td>
            <td <?= $diffColor ?>><?= $row['difference'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</form>

</body>
</html>

<?php $conn->close(); ?>



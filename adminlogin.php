
<?php
session_start();
include('dbconnect.php');


$valid_admins = [
    "super_admin" => "12345",  // Can access summary.php
    "stock_admin"   => "67890"   // Can access stock.php
];

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if(isset($valid_admins[$username]) && $valid_admins[$username] === $password) {
    $_SESSION['admin'] = $username;
    if ($username === "super_admin") {
        header("Location: superadmin.php");
    } elseif ($username === "stock_admin") {
        header("Location: stock.php");
    }
    exit;
} else {
    header("Location: adminlogin.html?error=Invalid credentials");
    exit;
}
?>
